<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Http\Requests\StoreVentaRequest;
use App\Mail\VentaValidadaVendedorMail;
use App\Mail\VentaValidadaCompradorMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;


class VentaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Venta::class);

        $usuario = Auth::user();

        if ($usuario->esCliente()) {
            // Cliente solo ve sus propias ventas
            $ventas = Venta::with('producto', 'cliente', 'vendedor')
                ->where('cliente_id', $usuario->id)
                ->get();
        } else {
            // Gerente y administrador ven todas
            $ventas = Venta::with('producto', 'cliente', 'vendedor')->get();
        }

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        // Verificamos manualmente el rol
        $usuario = Auth::user();
        if (!in_array($usuario->rol, ['cliente', 'gerente', 'administrador'])) {
            abort(403);
        }

        $productos = Producto::where('existencia', '>', 0)->get();
        return view('ventas.create', compact('productos'));
    }

    public function store(StoreVentaRequest $request)
    {
        $producto = \App\Models\Producto::findOrFail($request->producto_id);

        if ($producto->existencia < $request->cantidad) {
            return back()->withErrors([
                'cantidad' => 'No hay suficiente existencia. Solo quedan ' . $producto->existencia . ' unidades.'
            ])->withInput();
        }

        // Guardar ticket en disco privado
        $ticketPath = null;
        if ($request->hasFile('ticket')) {
            $ticketPath = $request->file('ticket')
                ->store('tickets', 'private');
        }

        $venta = Venta::create([
            'producto_id' => $request->producto_id,
            'vendedor_id' => $producto->usuario_id,
            'cliente_id'  => Auth::user()->id,
            'fecha'       => $request->fecha,
            'total'       => $request->total,
            'ticket'      => $ticketPath,
            'validada'    => false,
        ]);

        $producto->decrement('existencia', $request->cantidad);

        Log::channel('ventas')->info('Venta creada', [
            'venta_id'    => $venta->id,
            'producto_id' => $venta->producto_id,
            'total'       => $venta->total,
            'usuario_id'  => Auth::user()->id,
        ]);

        return redirect()->route('productos.index')
            ->with('success', '¡Compra realizada exitosamente!');
    }

    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);
        $venta->delete();
        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada.');
    }


    public function ticket(Venta $venta)
    {
        // Solo el dueño de la venta o un gerente puede ver el ticket
        if (Auth::user()->id !== $venta->cliente_id && !Auth::user()->esGerente() && !Auth::user()->esAdministrador()) {
            abort(403);
        }

        if (!$venta->ticket || !Storage::disk('private')->exists($venta->ticket)) {
            abort(404, 'Ticket no encontrado.');
        }

        return response()->file(
            Storage::disk('private')->path($venta->ticket)
        );
    }


    public function validar(Venta $venta)
    {
        if (!Auth::user()->esGerente() && !Auth::user()->esAdministrador()) {
            abort(403);
        }

        $venta->load('producto', 'vendedor', 'cliente');
        $venta->update(['validada' => true]);

        // Enviamos solo al vendedor primero
        try {
            Mail::to($venta->vendedor->correo)
                ->send(new VentaValidadaVendedorMail($venta));
        } catch (\Exception $e) {
            Log::channel('ventas')->warning('Error enviando correo al vendedor', [
                'error' => $e->getMessage()
            ]);
        }

        // Esperamos y enviamos al comprador
        sleep(5);

        try {
            Mail::to($venta->cliente->correo)
                ->send(new VentaValidadaCompradorMail($venta));
        } catch (\Exception $e) {
            Log::channel('ventas')->warning('Error enviando correo al comprador', [
                'error' => $e->getMessage()
            ]);
        }

        Log::channel('ventas')->info('Venta validada — correos enviados', [
            'venta_id'         => $venta->id,
            'vendedor_correo'  => $venta->vendedor->correo,
            'comprador_correo' => $venta->cliente->correo,
            'validado_por'     => Auth::user()->id,
        ]);

        return redirect()->route('ventas.index')
            ->with('success', 'Venta validada y correos enviados correctamente.');
    }



}
