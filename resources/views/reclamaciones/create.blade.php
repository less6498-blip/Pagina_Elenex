@extends('layouts.app')

@section('title', 'Libro de Reclamaciones - Elenex')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --lr-rojo: #C8102E;
        --lr-rojo-oscuro: #9B0D22;
        --lr-crema: #F5F0E8;
        --lr-gris-claro: #E8E4DC;
        --lr-gris-medio: #9B9589;
        --lr-gris-texto: #3A3530;
        --lr-dorado: #B8962E;
        --lr-negro: #1A1714;
        --lr-blanco: #FAFAF8;
        --lr-sombra: 0 4px 24px rgba(26,23,20,0.10);
        --lr-sombra-elevada: 0 8px 40px rgba(26,23,20,0.16);
    }

    .lr-page {
        padding-top: 200px;
        padding-bottom: 10px;
        text-align: center;
    }

    /* BANNER */
    .lr-banner {
        background: var(--lr-rojo);
        position: relative;
        overflow: hidden;
    }
    .lr-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0,0,0,0.04) 10px, rgba(0,0,0,0.04) 11px);
    }
    .lr-banner-inner {
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        padding: 28px 40px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .lr-escudo {
        width: 60px; height: 60px;
        background: var(--lr-dorado);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
    }
    .lr-banner-text h1 {
        font-family: 'Playfair Display', serif;
        color: #fff; font-size: 1.75rem; line-height: 1.2;
    }
    .lr-banner-text p {
        color: rgba(255,255,255,0.80); font-size: 0.82rem;
        font-weight: 300; margin-top: 4px;
        letter-spacing: 1.5px; text-transform: uppercase;
    }
    .lr-badge {
        margin-left: auto;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff; padding: 8px 16px; border-radius: 4px;
        font-size: 0.74rem; font-weight: 600; letter-spacing: 0.8px;
        text-align: center; flex-shrink: 0;
    }
    .lr-badge span { display: block; font-size: 0.63rem; font-weight: 300; opacity: 0.8; }

    /* AVISO */
    .lr-aviso {
        background: #fff;
        border-left: 4px solid var(--lr-dorado);
        max-width: 900px; margin: 28px auto 0;
        padding: 14px 22px; border-radius: 0 6px 6px 0;
        font-size: 0.81rem; color: var(--lr-gris-medio);
        line-height: 1.6; font-family: 'Source Sans 3', sans-serif;
    }
    .lr-aviso strong { color: var(--lr-gris-texto); }

    /* CONTAINER */
    .lr-container {
        max-width: 900px; margin: 0 auto;
        padding: 28px 20px 0;
        font-family: 'Source Sans 3', sans-serif;
    }

    /* ALERTAS */
    .lr-alert {
        padding: 13px 18px; border-radius: 6px;
        font-size: 0.87rem; display: flex;
        align-items: center; gap: 10px; margin-bottom: 18px;
        font-family: 'Source Sans 3', sans-serif;
    }
    .lr-alert-success { background: #F0FDF4; border: 1px solid #86EFAC; color: #166534; }
    .lr-alert-error   { background: #FFF1F2; border: 1px solid #FECDD3; color: #9B1C1C; }

    /* CARD */
    .lr-card {
        background: #fff; border-radius: 8px;
        box-shadow: var(--lr-sombra); overflow: hidden;
        border: 1px solid var(--lr-gris-claro);
    }

    /* SECCIONES */
    .lr-seccion { padding: 26px 34px; border-bottom: 1px solid var(--lr-gris-claro); }
    .lr-seccion:last-child { border-bottom: none; }
    .lr-seccion-titulo { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
    .lr-num {
        width: 27px; height: 27px; background: var(--lr-rojo); color: #fff;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 0.73rem; font-weight: 700; flex-shrink: 0;
    }
    .lr-seccion-titulo h2 {
        font-family: 'Roboto', sans-serif;
        font-size: 1.02rem; color: var(--lr-negro); margin-top: 5px;
    }
    .lr-linea { flex: 1; height: 1px; background: var(--lr-gris-claro); }

    /* GRID */
    .lr-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 18px; }
    .lr-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px 18px; }
    .lr-span-2 { grid-column: span 2; }
    .lr-span-3 { grid-column: span 3; }

    /* CAMPOS */
    .lr-campo { display: flex; flex-direction: column; gap: 5px; }
    .lr-campo label {
        font-size: 0.73rem; font-weight: 600; color: var(--lr-gris-medio);
        letter-spacing: 0.8px; text-transform: uppercase;
        font-family: 'Source Sans 3', sans-serif;
    }
    .lr-campo label .req { color: var(--lr-rojo); margin-left: 2px; }
    .lr-campo input,
    .lr-campo select,
    .lr-campo textarea {
        border: 1.5px solid var(--lr-gris-claro) !important;
        border-radius: 5px !important; padding: 9px 13px !important;
        font-size: 0.89rem !important; font-family: 'Source Sans 3', sans-serif !important;
        color: var(--lr-gris-texto) !important; background: var(--lr-blanco) !important;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none !important; width: 100%; box-shadow: none !important;
    }
    .lr-campo input:focus,
    .lr-campo select:focus,
    .lr-campo textarea:focus {
        border-color: var(--lr-rojo) !important;
        box-shadow: 0 0 0 3px rgba(200,16,46,0.08) !important;
    }
    .lr-campo textarea { resize: vertical; min-height: 95px; line-height: 1.55; }
    .lr-campo .lr-error-msg { font-size: 0.71rem; color: var(--lr-rojo); display: none; }
    .lr-campo.has-error .lr-error-msg { display: block; }
    .lr-campo.has-error input,
    .lr-campo.has-error select,
    .lr-campo.has-error textarea { border-color: var(--lr-rojo) !important; }

    /* TIPO RECLAMO */
    .lr-tipo-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px; }
    .lr-tipo-opcion { position: relative; }
    .lr-tipo-opcion input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
    .lr-tipo-opcion label {
        display: flex; flex-direction: column; gap: 5px;
        padding: 14px 18px; border: 2px solid var(--lr-gris-claro);
        border-radius: 7px; cursor: pointer; transition: all 0.2s;
        text-transform: none; letter-spacing: 0;
        font-size: 0.88rem; font-weight: 500; color: var(--lr-gris-texto);
        background: var(--lr-blanco); font-family: 'Source Sans 3', sans-serif;
    }
    .lr-tipo-opcion label .lr-tipo-icon  { font-size: 1.4rem; }
    .lr-tipo-opcion label .lr-tipo-nombre { font-weight: 600; font-size: 0.9rem; }
    .lr-tipo-opcion label .lr-tipo-desc   { font-size: 0.75rem; color: var(--lr-gris-medio); line-height: 1.4; }
    .lr-tipo-opcion input:checked + label { border-color: var(--lr-rojo); background: #FFF5F7; }
    .lr-tipo-opcion input:checked + label .lr-tipo-nombre { color: var(--lr-rojo); }

    /* AUTORIZACIÓN */
    .lr-autorizacion {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 18px; background: var(--lr-crema);
        border-radius: 6px; border: 1px solid var(--lr-gris-claro);
    }
    .lr-autorizacion input[type="checkbox"] {
        width: 17px; height: 17px; flex-shrink: 0;
        margin-top: 2px; accent-color: var(--lr-rojo); cursor: pointer;
    }
    .lr-autorizacion p { font-size: 0.81rem; line-height: 1.55; color: var(--lr-gris-medio); font-family: 'Source Sans 3', sans-serif; }
    .lr-autorizacion p strong { color: var(--lr-gris-texto); }

    /* FOOTER FORM */
    .lr-form-footer {
        padding: 22px 34px; background: var(--lr-crema);
        border-top: 1px solid var(--lr-gris-claro);
        display: flex; align-items: center; justify-content: space-between; gap: 20px;
    }
    .lr-footer-nota { font-size: 0.77rem; color: var(--lr-gris-medio); line-height: 1.5; max-width: 400px; font-family: 'Source Sans 3', sans-serif; }
    .lr-footer-nota strong { color: var(--lr-gris-texto); }
    .lr-btn-submit {
        background: var(--lr-rojo); color: #fff; border: none;
        padding: 13px 34px; border-radius: 5px;
        font-family: 'Source Sans 3', sans-serif; font-size: 0.9rem;
        font-weight: 600; letter-spacing: 0.4px; cursor: pointer;
        transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
        white-space: nowrap; flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(200,16,46,0.25);
    }
    .lr-btn-submit:hover { background: var(--lr-rojo-oscuro); box-shadow: 0 4px 16px rgba(200,16,46,0.35); transform: translateY(-1px); }
    .lr-btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

    /* MODAL */
    .lr-modal-overlay {
        position: fixed; inset: 0; background: rgba(26,23,20,0.6);
        display: none; align-items: center; justify-content: center;
        z-index: 9999; padding: 20px; backdrop-filter: blur(2px);
    }
    .lr-modal-overlay.active { display: flex; }
    .lr-modal {
        background: #fff; border-radius: 10px; padding: 38px;
        max-width: 460px; width: 100%; text-align: center;
        box-shadow: var(--lr-sombra-elevada); animation: lrModalIn 0.3s ease;
        font-family: 'Source Sans 3', sans-serif;
    }
    @keyframes lrModalIn { from { transform: scale(0.9) translateY(20px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
    .lr-modal-icon { width: 68px; height: 68px; background: #F0FDF4; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.9rem; margin: 0 auto 18px; }
    .lr-modal h3 { font-family: 'Playfair Display', serif; font-size: 1.35rem; color: var(--lr-negro); margin-bottom: 10px; }
    .lr-modal p { font-size: 0.86rem; color: var(--lr-gris-medio); line-height: 1.6; margin-bottom: 6px; }
    .lr-codigo { background: var(--lr-crema); border: 1px dashed var(--lr-dorado); border-radius: 5px; padding: 11px 18px; margin: 14px 0; font-family: monospace; font-size: 1.05rem; color: var(--lr-negro); font-weight: 700; letter-spacing: 2px; }
    .lr-btn-cerrar { background: var(--lr-rojo); color: #fff; border: none; padding: 11px 30px; border-radius: 5px; font-family: 'Source Sans 3', sans-serif; font-weight: 600; cursor: pointer; margin-top: 10px; font-size: 0.88rem; }

    /* SPINNER */
    .lr-spinner { display: inline-block; width: 15px; height: 15px; border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff; border-radius: 50%; animation: lrSpin 0.7s linear infinite; vertical-align: middle; margin-right: 7px; }
    @keyframes lrSpin { to { transform: rotate(360deg); } }

    /* RESPONSIVE */
    @media (max-width: 640px) {
        .lr-page h1 { margin-top: -60px; padding-bottom: -90px;}
        .lr-banner-inner { padding: 18px; flex-wrap: wrap; }
        .lr-badge { margin-left: 0; }
        .lr-seccion { padding: 18px; }
        .lr-grid-2, .lr-grid-3 { grid-template-columns: 1fr; }
        .lr-span-2, .lr-span-3 { grid-column: span 1; }
        .lr-tipo-selector { grid-template-columns: 1fr; }
        .lr-form-footer { flex-direction: column; align-items: stretch; }
        .lr-btn-submit { text-align: center; }
        .lr-container { padding: 14px 12px 0; }
        .lr-aviso { margin: 14px 12px 0; }
    }
</style>
@endpush

@section('content')
<div class="lr-page">
    <h1 style="font-weight:700;">Libro de Reclamaciones 📖</h1>
    </div>

    {{-- AVISO LEGAL --}}
    <div class="lr-aviso">
        <strong>Aviso legal:</strong> Conforme al código de protección y defensa del consumidor (Ley N° 29571) y el D.S. N° 011-2011-PCM, el proveedor responderá en un plazo máximo de <strong> 30 días calendario </strong>. La presentación de este formulario no impide acudir a INDECOPI u otras vías de solución de controversias.
    </div>

    <div class="lr-container">

        {{-- ALERTAS --}}
        @if(session('success'))
            <div class="lr-alert lr-alert-success">✅ <strong>{{ session('success') }}</strong></div>
        @endif
        @if($errors->any())
            <div class="lr-alert lr-alert-error">⚠️ <strong>Por favor corrija los errores indicados en el formulario.</strong></div>
        @endif

        <form id="lrForm" method="POST" action="{{ route('reclamaciones.store') }}" novalidate>
            @csrf
            <div class="lr-card">

                {{-- 1. DATOS DEL CONSUMIDOR --}}
                <div class="lr-seccion">
                    <div class="lr-seccion-titulo">
                        <div class="lr-num">1</div>
                        <h2>Identificación del Consumidor Reclamante</h2>
                        <div class="lr-linea"></div>
                    </div>
                    <div class="lr-grid-3">
                        <div class="lr-campo {{ $errors->has('tipo_documento') ? 'has-error' : '' }}">
                            <label>Tipo de Documento <span class="req">*</span></label>
                            <select name="tipo_documento" required>
                                <option value="">Seleccionar</option>
                                <option value="DNI"       {{ old('tipo_documento') == 'DNI'       ? 'selected' : '' }}>DNI</option>
                                <option value="CE"        {{ old('tipo_documento') == 'CE'        ? 'selected' : '' }}>Carné de Extranjería</option>
                                <option value="RUC"       {{ old('tipo_documento') == 'RUC'       ? 'selected' : '' }}>RUC</option>
                                <option value="PASAPORTE" {{ old('tipo_documento') == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                            </select>
                            <span class="lr-error-msg">{{ $errors->first('tipo_documento') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('numero_documento') ? 'has-error' : '' }}">
                            <label>N° de Documento <span class="req">*</span></label>
                            <input type="text" name="numero_documento" value="{{ old('numero_documento') }}" placeholder="Ej: 12345678" maxlength="15" required>
                            <span class="lr-error-msg">{{ $errors->first('numero_documento') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('nombres') ? 'has-error' : '' }}">
                            <label>Nombres <span class="req">*</span></label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}" placeholder="Nombres completos" required>
                            <span class="lr-error-msg">{{ $errors->first('nombres') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('apellido_paterno') ? 'has-error' : '' }}">
                            <label>Apellido Paterno <span class="req">*</span></label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno') }}" placeholder="Apellido paterno" required>
                            <span class="lr-error-msg">{{ $errors->first('apellido_paterno') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('apellido_materno') ? 'has-error' : '' }}">
                            <label>Apellido Materno <span class="req">*</span></label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno') }}" placeholder="Apellido materno" required>
                            <span class="lr-error-msg">{{ $errors->first('apellido_materno') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('telefono') ? 'has-error' : '' }}">
                            <label>Teléfono / Celular <span class="req">*</span></label>
                            <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 987654321" required>
                            <span class="lr-error-msg">{{ $errors->first('telefono') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo lr-span-2 {{ $errors->has('correo') ? 'has-error' : '' }}">
                            <label>Correo Electrónico <span class="req">*</span></label>
                            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="correo@ejemplo.com" required>
                            <span class="lr-error-msg">{{ $errors->first('correo') ?: 'Ingrese un correo válido' }}</span>
                        </div>
                        <div class="lr-campo" style="align-self: end;">
                            <label>¿Es Menor de Edad?</label>
                            <select name="es_menor">
                                <option value="0" {{ old('es_menor') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('es_menor') == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                        <div class="lr-campo lr-span-3 {{ $errors->has('direccion') ? 'has-error' : '' }}">
                            <label>Dirección <span class="req">*</span></label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Av./Jr./Calle, número, distrito, provincia, departamento" required>
                            <span class="lr-error-msg">{{ $errors->first('direccion') ?: 'Campo requerido' }}</span>
                        </div>
                    </div>
                </div>

                {{-- 2. BIEN CONTRATADO --}}
                <div class="lr-seccion">
                    <div class="lr-seccion-titulo">
                        <div class="lr-num">2</div>
                        <h2>Identificación del Bien Contratado</h2>
                        <div class="lr-linea"></div>
                    </div>
                    <div class="lr-grid-2" style="margin-bottom:14px; align-items: end;">
                        <div class="lr-campo {{ $errors->has('tipo_bien') ? 'has-error' : '' }}">
                            <label>Tipo de Bien <span class="req">*</span></label>
                            <select name="tipo_bien" required>
                                <option value="">Seleccionar</option>
                                <option value="PRODUCTO" {{ old('tipo_bien') == 'PRODUCTO' ? 'selected' : '' }}>Producto</option>
                                <option value="SERVICIO" {{ old('tipo_bien') == 'SERVICIO' ? 'selected' : '' }}>Servicio</option>
                            </select>
                            <span class="lr-error-msg">{{ $errors->first('tipo_bien') ?: 'Campo requerido' }}</span>
                        </div>
                        <div class="lr-campo {{ $errors->has('monto_reclamado') ? 'has-error' : '' }}">
                            <label>Monto Reclamado (S/)</label>
                            <input type="number" name="monto_reclamado" value="{{ old('monto_reclamado') }}" placeholder="0.00" step="0.01" min="0">
                            <span class="lr-error-msg">{{ $errors->first('monto_reclamado') }}</span>
                        </div>
                    </div>
                    <div class="lr-campo {{ $errors->has('descripcion_bien') ? 'has-error' : '' }}">
                        <label>Descripción del Producto o Servicio <span class="req">*</span></label>
                        <textarea name="descripcion_bien" rows="3" placeholder="Describa el producto o servicio contratado (nombre, modelo, número de pedido, etc.)" required>{{ old('descripcion_bien') }}</textarea>
                        <span class="lr-error-msg">{{ $errors->first('descripcion_bien') ?: 'Campo requerido' }}</span>
                    </div>
                </div>

                {{-- 3. TIPO DE RECLAMACIÓN --}}
                <div class="lr-seccion">
                    <div class="lr-seccion-titulo">
                        <div class="lr-num">3</div>
                        <h2>Tipo de Reclamación</h2>
                        <div class="lr-linea"></div>
                    </div>
                    <div class="lr-tipo-selector">
                        <div class="lr-tipo-opcion">
                            <input type="radio" name="tipo_reclamo" id="lr_reclamo" value="RECLAMO"
                                   {{ old('tipo_reclamo', 'RECLAMO') == 'RECLAMO' ? 'checked' : '' }} required>
                            <label for="lr_reclamo">
                                <span class="lr-tipo-icon">📋</span>
                                <span class="lr-tipo-nombre">Reclamo</span>
                                <span class="lr-tipo-desc">Disconformidad relacionada a los productos o servicios prestados.</span>
                            </label>
                        </div>
                        <div class="lr-tipo-opcion">
                            <input type="radio" name="tipo_reclamo" id="lr_queja" value="QUEJA"
                                   {{ old('tipo_reclamo') == 'QUEJA' ? 'checked' : '' }}>
                            <label for="lr_queja">
                                <span class="lr-tipo-icon">⚠️</span>
                                <span class="lr-tipo-nombre">Queja</span>
                                <span class="lr-tipo-desc">Disconformidad relacionada a la atención al consumidor brindada.</span>
                            </label>
                        </div>
                    </div>
                    <div class="lr-campo {{ $errors->has('detalle_reclamo') ? 'has-error' : '' }}">
                        <label>Detalle de la Reclamación <span class="req">*</span></label>
                        <textarea name="detalle_reclamo" rows="5" placeholder="Describa con precisión los hechos que motivan su reclamo o queja..." required>{{ old('detalle_reclamo') }}</textarea>
                        <span class="lr-error-msg">{{ $errors->first('detalle_reclamo') ?: 'Campo requerido' }}</span>
                    </div>
                </div>

                {{-- 4. PEDIDO DEL CONSUMIDOR --}}
                <div class="lr-seccion">
                    <div class="lr-seccion-titulo">
                        <div class="lr-num">4</div>
                        <h2>Pedido del Consumidor</h2>
                        <div class="lr-linea"></div>
                    </div>
                    <div class="lr-campo {{ $errors->has('pedido_consumidor') ? 'has-error' : '' }}">
                        <label>¿Cuál es su pedido o pretensión? <span class="req">*</span></label>
                        <textarea name="pedido_consumidor" rows="3" placeholder="Indique qué solución o compensación espera recibir..." required>{{ old('pedido_consumidor') }}</textarea>
                        <span class="lr-error-msg">{{ $errors->first('pedido_consumidor') ?: 'Campo requerido' }}</span>
                    </div>
                </div>

                {{-- 5. AUTORIZACIÓN --}}
                <div class="lr-seccion">
                    <div class="lr-seccion-titulo">
                        <div class="lr-num">5</div>
                        <h2>Autorización y Firma</h2>
                        <div class="lr-linea"></div>
                    </div>
                    <div class="lr-autorizacion">
                        <input type="checkbox" name="acepta_politica" id="lr_acepta" {{ old('acepta_politica') ? 'checked' : '' }} required>
                        <p>
                            <strong>Autorización de tratamiento de datos personales:</strong> Al marcar esta casilla, autorizo expresamente a <strong> ELENEX </strong> a registrar y tratar mis datos personales con el fin de atender mi reclamación, conforme a la Ley N° 29733. Declaro que la información proporcionada es verídica.
                        </p>
                    </div>
                </div>

                {{-- BOTÓN --}}
                <div class="lr-form-footer">
                    <p class="lr-footer-nota">
                        <strong>Fecha de presentación:</strong> {{ now()->timezone('America/Lima')->format('d/m/Y H:i') }}<br>
                        Recibirá confirmación en su correo electrónico registrado.
                    </p>
                    <button type="submit" class="lr-btn-submit" id="lrBtnSubmit">
                        Registrar Reclamación
                    </button>
                </div>

            </div>
        </form>
    </div>

</div>

{{-- MODAL ÉXITO --}}
@if(session('reclamo_registrado'))
<div class="lr-modal-overlay active" id="lrModalExito">
    <div class="lr-modal">
        <div class="lr-modal-icon">✅</div>
        <h3>Reclamación Registrada</h3>
        <p>Su reclamación ha sido registrada exitosamente.</p>
        <p>Su código de seguimiento es:</p>
        <div class="lr-codigo">{{ session('codigo_reclamo') }}</div>
        <p>Le responderemos a <strong>{{ session('correo_reclamo') }}</strong> en máximo 30 días calendario.</p>
        <button class="lr-btn-cerrar" onclick="document.getElementById('lrModalExito').classList.remove('active')">
            Aceptar
        </button>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    const lrForm = document.getElementById('lrForm');
    const lrBtn  = document.getElementById('lrBtnSubmit');

    lrForm.addEventListener('submit', function(e) {
        let valido = true;

        lrForm.querySelectorAll('[required]').forEach(function(el) {
            if (el.type === 'radio') return;
            const campo = el.closest('.lr-campo');
            if (!el.value.trim()) {
                if (campo) campo.classList.add('has-error');
                valido = false;
            } else {
                if (campo) campo.classList.remove('has-error');
            }
        });

        const cbk = document.getElementById('lr_acepta');
        if (!cbk.checked) {
            valido = false;
            alert('Debe aceptar la autorización de tratamiento de datos personales para continuar.');
        }

        if (!valido) {
            e.preventDefault();
            const primerError = lrForm.querySelector('.has-error');
            if (primerError) primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            lrBtn.disabled = true;
            lrBtn.innerHTML = '<span class="lr-spinner"></span>Enviando...';
        }
    });

    lrForm.querySelectorAll('input, select, textarea').forEach(function(el) {
        el.addEventListener('input', function() {
            const campo = el.closest('.lr-campo');
            if (campo && el.value.trim()) campo.classList.remove('has-error');
        });
    });
</script>
@endpush