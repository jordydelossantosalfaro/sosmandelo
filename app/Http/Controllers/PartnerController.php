<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    /**
     * Procesa el registro de nuevos socios (proveedores y repartidores)
     */
    public function register(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:255',
            'whatsapp' => 'required|regex:/^[0-9]{9}$/',
            'email' => 'required|email|max:255',
            'tipo_socio' => 'required|in:proveedor,repartidor'
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'whatsapp.regex' => 'El WhatsApp debe tener exactamente 9 dígitos.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'tipo_socio.required' => 'Debe seleccionar si es proveedor o repartidor.',
            'tipo_socio.in' => 'Tipo de socio inválido.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Por favor, corrige los errores en el formulario.');
        }

        $data = $validator->validated();

        try {
            // Enviar email con la información del nuevo socio
            Mail::send('emails.partner-registration', $data, function ($message) use ($data) {
                $message->to('sosmandelo@gmail.com')
                    ->subject('Nueva Solicitud de Socio - ' . ucfirst($data['tipo_socio']))
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->back()->with('success', 
                '¡Solicitud enviada exitosamente! Nos pondremos en contacto contigo pronto.');

        } catch (\Exception $e) {
            \Log::error('Error enviando email de registro de socio: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 
                'Hubo un problema al enviar tu solicitud. Por favor, inténtalo nuevamente o contáctanos directamente.');
        }
    }
}