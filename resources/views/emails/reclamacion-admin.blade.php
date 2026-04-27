<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva Reclamación</title>
</head>
<body style="margin:0;padding:0;background:#F3F4F6;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="620" cellpadding="0" cellspacing="0" style="max-width:620px;width:100%;">

          <!-- HEADER -->
          <tr>
            <td style="background:#1A1714;border-radius:8px 8px 0 0;padding:28px 40px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <p style="color:#9B9589;font-size:11px;letter-spacing:2px;text-transform:uppercase;margin:0 0 4px;">
                      LIBRO DE RECLAMACIONES · ELENEX
                    </p>
                    <h1 style="color:#fff;font-size:20px;margin:0;font-weight:700;">
                      ⚠️ Nueva reclamación registrada
                    </h1>
                  </td>
                  <td align="right" style="vertical-align:top;">
                    <span style="background:#C8102E;color:#fff;font-size:12px;font-weight:700;
                                 padding:5px 14px;border-radius:20px;white-space:nowrap;">
                      {{ $reclamacion->tipo_reclamo }}
                    </span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CÓDIGO Y FECHA -->
          <tr>
            <td style="background:#C8102E;padding:14px 40px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <p style="color:rgba(255,255,255,0.7);font-size:11px;margin:0;letter-spacing:1px;text-transform:uppercase;">Código</p>
                    <p style="color:#fff;font-size:18px;font-weight:700;font-family:monospace;letter-spacing:2px;margin:2px 0 0;">
                      {{ $reclamacion->codigo }}
                    </p>
                  </td>
                  <td align="right">
                    <p style="color:rgba(255,255,255,0.7);font-size:11px;margin:0;letter-spacing:1px;text-transform:uppercase;">Fecha de registro</p>
                    <p style="color:#fff;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ $reclamacion->created_at->format('d/m/Y H:i') }}
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- CUERPO -->
          <tr>
            <td style="background:#fff;padding:32px 40px;">

              <!-- DATOS DEL CONSUMIDOR -->
              <p style="color:#9B9589;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;
                         font-weight:600;margin:0 0 12px;border-bottom:1px solid #E5E7EB;padding-bottom:8px;">
                Datos del Consumidor
              </p>
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Nombre completo</p>
                    <p style="color:#1A1714;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ $reclamacion->nombres }} {{ $reclamacion->apellido_paterno }} {{ $reclamacion->apellido_materno }}
                    </p>
                  </td>
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Documento</p>
                    <p style="color:#1A1714;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ $reclamacion->tipo_documento }}: {{ $reclamacion->numero_documento }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Correo</p>
                    <p style="margin:2px 0 0;">
                      <a href="mailto:{{ $reclamacion->correo }}"
                         style="color:#C8102E;font-size:14px;font-weight:600;text-decoration:none;">
                        {{ $reclamacion->correo }}
                      </a>
                    </p>
                  </td>
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Teléfono</p>
                    <p style="color:#1A1714;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ $reclamacion->telefono }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding:5px 0;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Dirección</p>
                    <p style="color:#1A1714;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ $reclamacion->direccion }}
                    </p>
                  </td>
                </tr>
              </table>

              <!-- BIEN CONTRATADO -->
              <p style="color:#9B9589;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;
                         font-weight:600;margin:0 0 12px;border-bottom:1px solid #E5E7EB;padding-bottom:8px;">
                Bien Contratado
              </p>
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Tipo de bien</p>
                    <p style="color:#1A1714;font-size:14px;font-weight:600;margin:2px 0 0;">
                      {{ ucfirst(strtolower($reclamacion->tipo_bien)) }}
                    </p>
                  </td>
                  @if($reclamacion->monto_reclamado)
                  <td width="50%" style="padding:5px 0;vertical-align:top;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Monto reclamado</p>
                    <p style="color:#C8102E;font-size:16px;font-weight:700;margin:2px 0 0;">
                      S/ {{ number_format($reclamacion->monto_reclamado, 2) }}
                    </p>
                  </td>
                  @endif
                </tr>
                <tr>
                  <td colspan="2" style="padding:5px 0;">
                    <p style="color:#9B9589;font-size:12px;margin:0;">Descripción</p>
                    <p style="color:#1A1714;font-size:14px;margin:2px 0 0;line-height:1.6;">
                      {{ $reclamacion->descripcion_bien }}
                    </p>
                  </td>
                </tr>
              </table>

              <!-- DETALLE DE LA RECLAMACIÓN -->
              <p style="color:#9B9589;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;
                         font-weight:600;margin:0 0 12px;border-bottom:1px solid #E5E7EB;padding-bottom:8px;">
                Detalle de la Reclamación
              </p>
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td style="background:#FFF5F7;border-left:3px solid #C8102E;padding:14px 16px;border-radius:0 4px 4px 0;">
                    <p style="color:#3A3530;font-size:14px;margin:0;line-height:1.7;">
                      {{ $reclamacion->detalle_reclamo }}
                    </p>
                  </td>
                </tr>
              </table>

              <!-- PEDIDO -->
              <p style="color:#9B9589;font-size:11px;letter-spacing:1.5px;text-transform:uppercase;
                         font-weight:600;margin:0 0 12px;border-bottom:1px solid #E5E7EB;padding-bottom:8px;">
                Pedido del Consumidor
              </p>
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                <tr>
                  <td style="background:#F9FAFB;border:1px solid #E5E7EB;padding:14px 16px;border-radius:4px;">
                    <p style="color:#3A3530;font-size:14px;margin:0;line-height:1.7;">
                      {{ $reclamacion->pedido_consumidor }}
                    </p>
                  </td>
                </tr>
              </table>

              <!-- AVISO LEGAL -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="background:#FEF9C3;border:1px solid #FDE047;border-radius:6px;padding:14px 18px;">
                    <p style="color:#713F12;font-size:13px;margin:0;line-height:1.6;">
                      ⏰ <strong>Plazo legal:</strong> Debes responder esta reclamación en un máximo de
                      <strong>30 días calendario</strong> desde el
                      <strong>{{ $reclamacion->created_at->format('d/m/Y') }}</strong>
                      (fecha límite: <strong>{{ $reclamacion->created_at->addDays(30)->format('d/m/Y') }}</strong>).
                    </p>
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="background:#1A1714;border-radius:0 0 8px 8px;padding:20px 40px;text-align:center;">
              <p style="color:#9B9589;font-size:11px;margin:0;line-height:1.6;">
                IP de registro: {{ $reclamacion->ip_registro }} &nbsp;·&nbsp;
                Sistema de Libro de Reclamaciones · ELENEX<br>
                © {{ date('Y') }} · Todos los derechos reservados.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>