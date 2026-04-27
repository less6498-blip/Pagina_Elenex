<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmación de Reclamación</title>
</head>
<body style="margin:0;padding:0;background:#F5F0E8;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#F5F0E8;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

          <!-- HEADER -->
          <tr>
            <td style="background:#C8102E;border-radius:8px 8px 0 0;padding:32px 40px;text-align:center;">
              <p style="color:rgba(255,255,255,0.7);font-size:11px;letter-spacing:2px;text-transform:uppercase;margin:0 0 6px;">
                LIBRO DE RECLAMACIONES
              </p>
              <h1 style="color:#fff;font-size:22px;margin:0;font-weight:700;letter-spacing:0.5px;">
                Hemos recibido tu reclamación
              </h1>
            </td>
          </tr>

          <!-- CUERPO -->
          <tr>
            <td style="background:#fff;padding:36px 40px;">

              <p style="color:#3A3530;font-size:15px;margin:0 0 20px;line-height:1.6;">
                Estimado/a <strong>{{ $reclamacion->nombres }} {{ $reclamacion->apellido_paterno }}</strong>,
              </p>
              <p style="color:#5a5550;font-size:14px;margin:0 0 28px;line-height:1.7;">
                Confirmamos que hemos recibido correctamente tu
                <strong>{{ $reclamacion->tipo_reclamo == 'RECLAMO' ? 'reclamo' : 'queja' }}</strong>
                registrado el <strong>{{ $reclamacion->created_at->format('d/m/Y') }}</strong>
                a las <strong>{{ $reclamacion->created_at->format('H:i') }}</strong> horas.
                Nuestro equipo lo revisará y te daremos una respuesta en el plazo establecido por ley.
              </p>

              <!-- CÓDIGO -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                <tr>
                  <td style="background:#F5F0E8;border:1px dashed #B8962E;border-radius:6px;padding:18px 24px;text-align:center;">
                    <p style="color:#9B9589;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;margin:0 0 6px;">
                      Código de seguimiento
                    </p>
                    <p style="color:#1A1714;font-size:22px;font-weight:700;letter-spacing:3px;font-family:monospace;margin:0;">
                      {{ $reclamacion->codigo }}
                    </p>
                    <p style="color:#9B9589;font-size:11px;margin:6px 0 0;">
                      Guarda este código para hacer seguimiento de tu caso
                    </p>
                  </td>
                </tr>
              </table>

              <!-- DETALLE -->
              <table width="100%" cellpadding="0" cellspacing="0"
                     style="background:#FAFAF8;border:1px solid #E8E4DC;border-radius:6px;margin-bottom:28px;">
                <tr>
                  <td style="padding:20px 24px;">
                    <p style="color:#9B9589;font-size:11px;letter-spacing:1.2px;text-transform:uppercase;margin:0 0 14px;font-weight:600;">
                      Resumen de tu reclamación
                    </p>

                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;">
                          <span style="color:#9B9589;font-size:13px;">Tipo</span>
                        </td>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;text-align:right;">
                          <span style="color:#3A3530;font-size:13px;font-weight:600;">
                            {{ $reclamacion->tipo_reclamo == 'RECLAMO' ? '📋 Reclamo' : '⚠️ Queja' }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;">
                          <span style="color:#9B9589;font-size:13px;">Bien reclamado</span>
                        </td>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;text-align:right;">
                          <span style="color:#3A3530;font-size:13px;font-weight:600;">
                            {{ ucfirst(strtolower($reclamacion->tipo_bien)) }}
                          </span>
                        </td>
                      </tr>
                      @if($reclamacion->monto_reclamado)
                      <tr>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;">
                          <span style="color:#9B9589;font-size:13px;">Monto reclamado</span>
                        </td>
                        <td style="padding:6px 0;border-bottom:1px solid #E8E4DC;text-align:right;">
                          <span style="color:#3A3530;font-size:13px;font-weight:600;">
                            S/ {{ number_format($reclamacion->monto_reclamado, 2) }}
                          </span>
                        </td>
                      </tr>
                      @endif
                      <tr>
                        <td style="padding:6px 0;">
                          <span style="color:#9B9589;font-size:13px;">Estado actual</span>
                        </td>
                        <td style="padding:6px 0;text-align:right;">
                          <span style="background:#FFF7ED;color:#C2410C;font-size:12px;font-weight:600;
                                       padding:3px 10px;border-radius:20px;border:1px solid #FED7AA;">
                            PENDIENTE
                          </span>
                        </td>
                      </tr>
                    </table>

                  </td>
                </tr>
              </table>

              <!-- AVISO PLAZO -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td style="background:#FFF5F7;border-left:4px solid #C8102E;border-radius:0 6px 6px 0;padding:14px 18px;">
                    <p style="color:#3A3530;font-size:13px;margin:0;line-height:1.6;">
                      📅 <strong>Plazo de respuesta:</strong> Según el Código de Protección y Defensa del Consumidor
                      (Ley N° 29571), daremos respuesta a tu caso en un máximo de <strong>30 días calendario</strong>
                      contados desde hoy.
                    </p>
                  </td>
                </tr>
              </table>

              <p style="color:#5a5550;font-size:14px;margin:0;line-height:1.7;">
                Si tienes alguna consulta sobre tu reclamación, puedes escribirnos a
                <a href="mailto:{{ config('mail.from.address') }}"
                   style="color:#C8102E;text-decoration:none;font-weight:600;">
                  {{ config('mail.from.address') }}
                </a>
                indicando tu código de seguimiento.
              </p>
            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="background:#1A1714;border-radius:0 0 8px 8px;padding:24px 40px;text-align:center;">
              <p style="color:#fff;font-size:14px;font-weight:700;margin:0 0 4px;letter-spacing:1px;">
                ELENEX
              </p>
              <p style="color:#9B9589;font-size:12px;margin:0 0 12px;">
                Moda urbana y casual · Perú
              </p>
              <p style="color:#5a5550;font-size:11px;margin:0;line-height:1.6;">
                Este correo fue enviado automáticamente. Por favor no respondas directamente a este mensaje.<br>
                © {{ date('Y') }} ELENEX · Todos los derechos reservados.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>