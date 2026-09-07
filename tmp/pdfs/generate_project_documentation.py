from __future__ import annotations

from pathlib import Path
from datetime import date

from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER, TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import mm
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.platypus import (
    BaseDocTemplate,
    Frame,
    Image,
    KeepTogether,
    PageBreak,
    PageTemplate,
    Paragraph,
    Spacer,
    Table,
    TableStyle,
)


PROJECT_ROOT = Path(r"C:\laragon\www\haro_proyect")
OUTPUT = PROJECT_ROOT / "output" / "pdf" / "documentacion_general_haro_seminuevos.pdf"
LOGO = PROJECT_ROOT / "assets" / "media" / "general" / "haro-logo.png"

PAGE_W, PAGE_H = A4
MARGIN_X = 17 * mm
MARGIN_TOP = 18 * mm
MARGIN_BOTTOM = 16 * mm
CONTENT_W = PAGE_W - 2 * MARGIN_X

RED = colors.HexColor("#C9252C")
DARK = colors.HexColor("#1F2933")
SLATE = colors.HexColor("#52606D")
MID = colors.HexColor("#7B8794")
LIGHT = colors.HexColor("#F3F5F7")
PALE_RED = colors.HexColor("#FCEBEC")
PALE_GREEN = colors.HexColor("#EAF6EF")
GREEN = colors.HexColor("#247A48")
LINE = colors.HexColor("#D9DEE3")
WHITE = colors.white


def register_fonts() -> None:
    candidates = {
        "HaroSans": Path(r"C:\Windows\Fonts\arial.ttf"),
        "HaroSans-Bold": Path(r"C:\Windows\Fonts\arialbd.ttf"),
        "HaroSans-Italic": Path(r"C:\Windows\Fonts\ariali.ttf"),
        "HaroSans-BoldItalic": Path(r"C:\Windows\Fonts\arialbi.ttf"),
    }
    if all(path.exists() for path in candidates.values()):
        for name, path in candidates.items():
            pdfmetrics.registerFont(TTFont(name, str(path)))
        pdfmetrics.registerFontFamily(
            "HaroSans",
            normal="HaroSans",
            bold="HaroSans-Bold",
            italic="HaroSans-Italic",
            boldItalic="HaroSans-BoldItalic",
        )


register_fonts()
FONT = "HaroSans" if "HaroSans" in pdfmetrics.getRegisteredFontNames() else "Helvetica"
FONT_BOLD = "HaroSans-Bold" if "HaroSans-Bold" in pdfmetrics.getRegisteredFontNames() else "Helvetica-Bold"

styles = getSampleStyleSheet()
styles.add(ParagraphStyle(
    "CoverKicker", fontName=FONT_BOLD, fontSize=9, leading=12, textColor=RED,
    spaceAfter=9, tracking=1.1,
))
styles.add(ParagraphStyle(
    "CoverTitle", fontName=FONT_BOLD, fontSize=27, leading=31, textColor=DARK,
    spaceAfter=10,
))
styles.add(ParagraphStyle(
    "CoverSub", fontName=FONT, fontSize=11, leading=16, textColor=SLATE,
    spaceAfter=7,
))
styles.add(ParagraphStyle(
    "H1", fontName=FONT_BOLD, fontSize=18, leading=22, textColor=DARK,
    spaceAfter=7,
))
styles.add(ParagraphStyle(
    "H2", fontName=FONT_BOLD, fontSize=11.5, leading=15, textColor=RED,
    spaceBefore=7, spaceAfter=5,
))
styles.add(ParagraphStyle(
    "Body", fontName=FONT, fontSize=8.5, leading=12.3, textColor=DARK,
    spaceAfter=5,
))
styles.add(ParagraphStyle(
    "Small", fontName=FONT, fontSize=7.5, leading=10.5, textColor=SLATE,
    spaceAfter=3,
))
styles.add(ParagraphStyle(
    "SmallWhite", fontName=FONT, fontSize=7.5, leading=10, textColor=WHITE,
))
styles.add(ParagraphStyle(
    "SmallBold", fontName=FONT_BOLD, fontSize=7.6, leading=10.5, textColor=DARK,
))
styles.add(ParagraphStyle(
    "Cell", fontName=FONT, fontSize=7.15, leading=9.6, textColor=DARK,
))
styles.add(ParagraphStyle(
    "CellBold", fontName=FONT_BOLD, fontSize=7.15, leading=9.6, textColor=DARK,
))
styles.add(ParagraphStyle(
    "CellWhite", fontName=FONT_BOLD, fontSize=7.15, leading=9.6, textColor=WHITE,
))
styles.add(ParagraphStyle(
    "HaroCode", fontName="Courier", fontSize=7, leading=9.5, textColor=DARK,
    leftIndent=7, rightIndent=7, spaceBefore=3, spaceAfter=5,
))
styles.add(ParagraphStyle(
    "Callout", fontName=FONT, fontSize=8.3, leading=12, textColor=DARK,
    leftIndent=8, rightIndent=8, spaceBefore=4, spaceAfter=4,
))
styles.add(ParagraphStyle(
    "Center", fontName=FONT, fontSize=8, leading=11, textColor=SLATE,
    alignment=TA_CENTER,
))


def P(text: str, style: str = "Body") -> Paragraph:
    return Paragraph(text, styles[style])


def bullet(text: str) -> Paragraph:
    return Paragraph(f"- {text}", ParagraphStyle(
        "bullet-temp", parent=styles["Body"], leftIndent=9, firstLineIndent=-7,
        spaceAfter=3,
    ))


def heading(number: str, title: str, subtitle: str | None = None):
    items = [P(f"{number}  {title}", "H1")]
    if subtitle:
        items.append(P(subtitle, "Small"))
    items.append(Spacer(1, 2 * mm))
    return items


def table(data, widths, header=True, font_size=7.15, row_bgs=None):
    wrapped = []
    for r, row in enumerate(data):
        wrapped.append([
            cell if hasattr(cell, "wrap") else P(str(cell), "CellWhite" if header and r == 0 else "Cell")
            for cell in row
        ])
    t = Table(wrapped, colWidths=widths, repeatRows=1 if header else 0, hAlign="LEFT")
    ts = [
        ("VALIGN", (0, 0), (-1, -1), "TOP"),
        ("FONTNAME", (0, 0), (-1, -1), FONT),
        ("FONTSIZE", (0, 0), (-1, -1), font_size),
        ("LEFTPADDING", (0, 0), (-1, -1), 5),
        ("RIGHTPADDING", (0, 0), (-1, -1), 5),
        ("TOPPADDING", (0, 0), (-1, -1), 4),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 4),
        ("GRID", (0, 0), (-1, -1), 0.35, LINE),
    ]
    if header:
        ts += [("BACKGROUND", (0, 0), (-1, 0), DARK), ("TEXTCOLOR", (0, 0), (-1, 0), WHITE)]
        for r in range(1, len(data)):
            if r % 2 == 0:
                ts.append(("BACKGROUND", (0, r), (-1, r), LIGHT))
    if row_bgs:
        for r, bg in row_bgs.items():
            ts.append(("BACKGROUND", (0, r), (-1, r), bg))
    t.setStyle(TableStyle(ts))
    return t


def callout(title: str, text: str, color=PALE_RED):
    body = Table([
        [P(title, "CellBold"), P(text, "Callout")]
    ], colWidths=[37 * mm, CONTENT_W - 37 * mm])
    body.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, -1), color),
        ("BOX", (0, 0), (-1, -1), 0.7, RED if color == PALE_RED else GREEN),
        ("VALIGN", (0, 0), (-1, -1), "MIDDLE"),
        ("LEFTPADDING", (0, 0), (-1, -1), 7),
        ("RIGHTPADDING", (0, 0), (-1, -1), 7),
        ("TOPPADDING", (0, 0), (-1, -1), 6),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 6),
    ]))
    return body


def architecture_flow():
    rows = [
        [P("NAVEGADOR", "CellWhite"), P("Sitio público y panel administrativo", "CellWhite")],
        [P("PRESENTACIÓN", "CellBold"), P("PHP + HTML, Bootstrap 4, jQuery y complementos de interfaz", "Cell")],
        [P("APLICACIÓN", "CellBold"), P("Páginas PHP, controladores por acción y administradores de dominio", "Cell")],
        [P("DOMINIO", "CellBold"), P("Autos, catálogos, clientes, ventas, pagos, almacenes, usuarios y estadísticas", "Cell")],
        [P("DATOS", "CellBold"), P("Conectores mysqli compartidos, variables de <b>.env</b> y MariaDB", "Cell")],
        [P("INTEGRACIONES", "CellBold"), P("Correo SMTP, Meta/Facebook, Mercado Libre y tareas programadas", "Cell")],
    ]
    t = Table(rows, colWidths=[38 * mm, CONTENT_W - 38 * mm])
    ts = [
        ("BACKGROUND", (0, 0), (-1, 0), RED),
        ("BACKGROUND", (0, 1), (0, -1), LIGHT),
        ("GRID", (0, 0), (-1, -1), 0.6, LINE),
        ("VALIGN", (0, 0), (-1, -1), "MIDDLE"),
        ("LEFTPADDING", (0, 0), (-1, -1), 7),
        ("RIGHTPADDING", (0, 0), (-1, -1), 7),
        ("TOPPADDING", (0, 0), (-1, -1), 8),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 8),
    ]
    t.setStyle(TableStyle(ts))
    return t


def draw_page(canvas, doc):
    canvas.saveState()
    if doc.page > 1:
        canvas.setStrokeColor(LINE)
        canvas.setLineWidth(0.5)
        canvas.line(MARGIN_X, PAGE_H - 12 * mm, PAGE_W - MARGIN_X, PAGE_H - 12 * mm)
        canvas.setFont(FONT_BOLD, 7)
        canvas.setFillColor(DARK)
        canvas.drawString(MARGIN_X, PAGE_H - 9 * mm, "HARO SEMINUEVOS  /  DOCUMENTACIÓN GENERAL")
        canvas.setFont(FONT, 7)
        canvas.setFillColor(MID)
        canvas.drawRightString(PAGE_W - MARGIN_X, 9 * mm, f"Página {doc.page}")
    canvas.restoreState()


def build_story():
    story = []

    # Cover
    story.append(Spacer(1, 15 * mm))
    if LOGO.exists():
        logo = Image(str(LOGO), width=42 * mm, height=24.8 * mm)
        logo.hAlign = "LEFT"
        story.append(logo)
    story.append(Spacer(1, 25 * mm))
    story.append(P("DOCUMENTACIÓN TÉCNICA Y OPERATIVA", "CoverKicker"))
    story.append(P("Proyecto Haro Seminuevos", "CoverTitle"))
    story.append(P("Guía general del sitio público, panel administrativo, datos, configuración y mantenimiento.", "CoverSub"))
    story.append(Spacer(1, 11 * mm))
    cover_meta = Table([
        [P("ALCANCE", "CellBold"), P("Raíz pública del proyecto y carpeta <b>admin/</b>", "Cell")],
        [P("COMPATIBILIDAD", "CellBold"), P("PHP 8.3 o superior y MariaDB/MySQL mediante mysqli", "Cell")],
        [P("VERSIÓN", "CellBold"), P("1.0 - 2 de septiembre de 2026", "Cell")],
        [P("CARÁCTER", "CellBold"), P("Documento de arquitectura, instalación, operación y evolución", "Cell")],
    ], colWidths=[38 * mm, 112 * mm])
    cover_meta.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (0, -1), LIGHT),
        ("GRID", (0, 0), (-1, -1), 0.5, LINE),
        ("VALIGN", (0, 0), (-1, -1), "MIDDLE"),
        ("LEFTPADDING", (0, 0), (-1, -1), 8),
        ("RIGHTPADDING", (0, 0), (-1, -1), 8),
        ("TOPPADDING", (0, 0), (-1, -1), 8),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 8),
    ]))
    story.append(cover_meta)
    story.append(Spacer(1, 16 * mm))
    story.append(callout(
        "Nota de seguridad",
        "La documentación enumera nombres de variables de entorno, pero omite deliberadamente usuarios, contraseñas, tokens y valores operativos.",
        PALE_GREEN,
    ))
    story.append(PageBreak())

    # 1
    story += heading("01", "Resumen ejecutivo", "Qué es el sistema, qué cubre este documento y cuál es su estado técnico.")
    story.append(P(
        "Haro Seminuevos es una aplicación web PHP para publicar inventario automotriz y administrar su ciclo comercial. La raíz del proyecto concentra la experiencia pública; <b>admin/</b> reúne autenticación, catálogos, inventario, clientes, publicaciones, estadísticas y un submódulo de banca para ventas, pagos y almacenes.",
    ))
    story.append(P("Alcance documentado", "H2"))
    for item in [
        "Páginas PHP ubicadas directamente en la raíz y sus recursos públicos.",
        "Todo el árbol <b>admin/</b>, incluidas sus APIs, plantillas, tareas y módulo <b>admin/banca/</b>.",
        "Conectividad a base de datos, variables de entorno, modelo de datos conceptual y consultas críticas.",
        "Procedimientos de instalación, validación, operación, seguridad y mantenimiento.",
    ]:
        story.append(bullet(item))
    story.append(P("Fuera de alcance", "H2"))
    story.append(P("Las demás carpetas de la raíz se consideran fuera del encargo, salvo recursos estáticos que son consumidos directamente por las páginas públicas o administrativas."))
    story.append(P("Estado observado", "H2"))
    status = [
        ["Área", "Resultado"],
        ["Compatibilidad", "572 archivos PHP del alcance pasan validación sintáctica sin fallas."],
        ["Configuración", "Los conectores de datos y el publicador de Facebook leen parámetros desde <b>.env</b>."],
        ["Datos", "Conexiones verificadas con <b>utf8mb4</b> y reutilización perezosa de mysqli."],
        ["Rendimiento", "Se redujeron patrones N+1, se agruparon estadísticas y se aplicaron 17 índices."],
        ["Pruebas web", "Rutas públicas y administrativas críticas responden con estados HTTP esperados."],
    ]
    story.append(table(status, [37 * mm, CONTENT_W - 37 * mm]))
    story.append(Spacer(1, 4 * mm))
    story.append(callout("Lectura recomendada", "Desarrollo: secciones 03, 06, 07 y 09. Operación: 08, 11 y 12. Seguridad y evolución: 10 y 13.", PALE_GREEN))
    story.append(PageBreak())

    # 2
    story += heading("02", "Arquitectura de la solución", "Vista lógica de capas, ejecución y dependencias principales.")
    story.append(architecture_flow())
    story.append(P("Flujo de una petición", "H2"))
    flow = [
        ["Paso", "Descripción"],
        ["1", "El navegador solicita una página pública o una pantalla protegida de <b>admin/</b>."],
        ["2", "La página incluye plantillas, valida sesión cuando aplica y obtiene parámetros de entrada."],
        ["3", "Un administrador de dominio coordina entidades y consultas, o una API despacha por el parámetro POST <b>accion</b>."],
        ["4", "El conector crea o reutiliza mysqli con los valores cargados por <b>env.php</b>."],
        ["5", "La respuesta se presenta como HTML o como JSON/texto para llamadas asíncronas."],
    ]
    story.append(table(flow, [17 * mm, CONTENT_W - 17 * mm]))
    story.append(P("Componentes transversales", "H2"))
    components = [
        ["Componente", "Responsabilidad"],
        ["env.php", "Carga el archivo raíz <b>.env</b> sin depender de Composer y expone lectura tipada por nombre."],
        ["conectorBD.php", "Abre mysqli bajo demanda, configura <b>utf8mb4</b>, reutiliza la conexión y encapsula errores."],
        ["templates/", "Cabeceras, menús, pie, control de sesión y recursos compartidos."],
        ["administradores", "Agrupan reglas y operaciones para autos, usuarios, clientes, pagos, ventas y otras entidades."],
        ["api*.php", "Puntos de entrada para operaciones AJAX y acciones administrativas."],
    ]
    story.append(table(components, [39 * mm, CONTENT_W - 39 * mm]))
    story.append(PageBreak())

    # 3
    story += heading("03", "Estructura del proyecto", "Mapa práctico de directorios y archivos canónicos.")
    tree = """C:\\laragon\\www\\haro_proyect\\
|- .env / .env.example / .htaccess / .gitignore
|- env.php
|- index.php
|- inventory-list.php
|- vehicle-details.php
|- contacts.php / car-hunter.php / suscripciones.php / cotizador.php
|- assets/                         recursos usados por la interfaz
`- admin/
   |- index.php / login.php
   |- autos*.php / galeria.php / catalogos*.php / users.php
   |- api/                         dominio, conectores y endpoints
   |- templates/                   navegación y control de sesión
   |- sql/optimizacion_indices.sql
   `- banca/
      |- pantallas de ventas, pagos, clientes, inventario y almacenes
      |- api/                       dominio y endpoints de banca
      `- templates/                navegación y sesión de banca"""
    code_box = Table([[P(tree.replace("\n", "<br/>"), "HaroCode")]], colWidths=[CONTENT_W])
    code_box.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, -1), LIGHT),
        ("BOX", (0, 0), (-1, -1), 0.6, LINE),
        ("LEFTPADDING", (0, 0), (-1, -1), 8),
        ("RIGHTPADDING", (0, 0), (-1, -1), 8),
        ("TOPPADDING", (0, 0), (-1, -1), 7),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 7),
    ]))
    story.append(code_box)
    story.append(P("Convención de archivos", "H2"))
    conventions = [
        ["Patrón", "Interpretación"],
        ["index.php", "Página de abordaje pública y punto principal del sitio."],
        ["apiNombre.php", "Despachador de acciones de un dominio administrativo."],
        ["Administrador*.php", "Servicio de acceso y coordinación de datos."],
        ["Nombre.php", "Entidad o modelo del dominio."],
        ["*_o.php, *_dev.php, sufijos 2 o _pre", "Variantes históricas o de prueba. No deben considerarse canónicas sin una verificación funcional."],
    ]
    story.append(table(conventions, [48 * mm, CONTENT_W - 48 * mm]))
    story.append(Spacer(1, 4 * mm))
    story.append(callout("Deuda estructural", "Existen varias versiones alternativas de páginas y endpoints. Antes de retirarlas, identificar llamadas reales, cubrirlas con pruebas y conservar una sola implementación canónica."))
    story.append(PageBreak())

    # 4
    story += heading("04", "Sitio público", "Responsabilidades de las rutas principales de la raíz.")
    public_routes = [
        ["Archivo", "Función principal", "Datos destacados"],
        ["index.php", "Página de abordaje, inventario destacado, marcas y filtros.", "Autos activos, banners, contadores y rangos de precio."],
        ["inventory-list.php", "Listado navegable con búsqueda, filtros y paginación.", "Marca, modelo, año, precio y atributos del vehículo."],
        ["vehicle-details.php", "Ficha individual de un vehículo.", "Datos técnicos, precio, imágenes y estado."],
        ["car-hunter.php", "Captura la solicitud de búsqueda asistida.", "Preferencias, presupuesto y contacto."],
        ["contacts.php", "Formulario general de contacto.", "Datos del prospecto y mensaje."],
        ["suscripciones.php", "Alta de suscriptores.", "Correo y registro de interés."],
        ["cotizador.php", "Interfaz de cotización.", "Vehículo y parámetros comerciales."],
        ["dealers.php / dealers-info.php", "Presentación de información para distribuidores.", "Contenido editorial y llamadas a la acción."],
        ["blog-main.php / blog-post.php", "Vistas editoriales del blog.", "Listado y detalle de contenido."],
    ]
    story.append(table(public_routes, [37 * mm, 64 * mm, CONTENT_W - 101 * mm]))
    story.append(P("Comportamiento esperado", "H2"))
    for item in [
        "Los identificadores numéricos deben validarse antes de consultar. La ficha devuelve 400 para un identificador inválido y 404 si el auto no existe.",
        "Los filtros se resuelven en SQL para evitar cargar y descartar registros en PHP.",
        "Las imágenes y catálogos se cargan por lote o con caché para impedir consultas repetitivas por cada auto.",
        "La codificación de salida y de conexión debe permanecer en UTF-8/utf8mb4.",
    ]:
        story.append(bullet(item))
    story.append(P("Capa visual actual", "H2"))
    story.append(P("La interfaz utiliza Bootstrap 4.1.3, jQuery 3.3.1 con Migrate, Font Awesome 6.5, bootstrap-select, Magnific Popup, Easy Pie Chart, Slider Pro y Slick. Cualquier actualización debe hacerse por etapas y con revisión visual, porque la estructura y los complementos comparten estilos y eventos."))
    story.append(PageBreak())

    # 5
    story += heading("05", "Panel administrativo y banca", "Módulos funcionales protegidos por sesión y permisos.")
    modules = [
        ["Módulo", "Pantallas o clases", "Responsabilidad"],
        ["Acceso", "login.php, templates", "Inicio de sesión y validación de <b>sesionUsuario</b>, permisos generales y permiso de banca."],
        ["Autos", "autos.php, autos-nuevo.php, autos_mod.php", "Alta, edición, consulta y publicación de vehículos."],
        ["Ciclo de inventario", "autos-consig.php, autos-inactivo.php, autos-ventas.php", "Consignación, pausados/inactivos e históricos de venta."],
        ["Galería", "galeria.php, Imagen", "Carga, orden y asociación de fotografías."],
        ["Catálogos", "marca, modelo, interiores, transmisiones", "Datos normalizados usados en altas y filtros."],
        ["Usuarios", "users.php, Usuario, administradorUsuarios", "Cuentas, permisos y recuperación de acceso."],
        ["Prospectos", "Contacto, CarHunter, notificaciones", "Seguimiento de contactos y búsquedas solicitadas."],
        ["Estadísticas", "Visita, Mes, VisitasAuto", "Métricas mensuales y actividad por vehículo."],
        ["Banca", "Venta, Pago, PagoEvento, ClienteBanca, Almacen", "Ventas, saldos, pagos, clientes, almacenes e inventario financiero."],
    ]
    story.append(table(modules, [30 * mm, 51 * mm, CONTENT_W - 81 * mm]))
    story.append(P("Sesión y autorización", "H2"))
    story.append(P("La sesión administrativa se concentra en <b>$_SESSION['sesionUsuario']</b> y conserva identificador, permisos, permiso de banca e imagen. Las plantillas bloquean pantallas protegidas y <b>admin/index.php</b> redirige al área de banca. Los endpoints deben repetir la autorización en servidor; ocultar un botón no sustituye el control de permisos."))
    story.append(P("Tareas operativas", "H2"))
    jobs = [
        ["Archivo", "Propósito"],
        ["borrarPausadosYEliminadosSoloAutos.php", "Limpieza controlada de autos pausados o eliminados."],
        ["jobAsignarPortada.php", "Asignación de portada para vehículos."],
        ["notificadorAutos.php / notificadorAutosBet.php", "Notificaciones relacionadas con el estado del inventario."],
        ["recividorEmail.php / dev-recividorEmail.php", "Recepción o procesamiento de correo."],
        ["posteadorFacebook.php", "Publicación en Facebook con token leído desde el entorno."],
    ]
    story.append(table(jobs, [61 * mm, CONTENT_W - 61 * mm]))
    story.append(PageBreak())

    # 6
    story += heading("06", "APIs y servicios de dominio", "Mapa de endpoints y patrón de interacción administrativa.")
    apis = [
        ["Grupo", "Endpoints representativos", "Operaciones"],
        ["Autos", "apiAuto.php, apiAutoPmail.php, apiAutoPrueba.php", "CRUD, imágenes, portada, pausa, banner, publicación, historial y validación de almacén."],
        ["Catálogos", "apiEditor.php", "Marcas, modelos, interiores y transmisiones."],
        ["Personas", "apiCliente.php, apiClientes.php, apiUsuarios.php", "Clientes, usuarios, sesión, permisos, token y recuperación."],
        ["Relación comercial", "apiContactos.php, apiCarHunter.php", "Contactos, solicitudes y notificaciones."],
        ["Contenido e integración", "apiPublicaciones.php, apiMercadolibre.php", "Publicaciones y comunicación con canales externos."],
        ["Sistema", "apiConfiguraciones.php, apiEstadisticas.php", "Parámetros y agregación de métricas."],
        ["Banca", "apiAlmacen.php, apiClientes.php, apiPagos.php, apiVentas.php", "Almacenes, clientes, abonos, eventos y ventas."],
    ]
    story.append(table(apis, [31 * mm, 65 * mm, CONTENT_W - 96 * mm]))
    story.append(P("Patrón de llamada", "H2"))
    pattern = [
        ["Entrada", "Solicitud HTTP, normalmente POST, con <b>accion</b> y los campos de la operación."],
        ["Despacho", "El endpoint identifica la acción, valida datos y llama al administrador de dominio."],
        ["Persistencia", "El administrador ejecuta consultas por medio del conector mysqli compartido."],
        ["Salida", "Respuesta JSON o texto consumido por JavaScript; los errores de conexión se registran sin revelar secretos."],
    ]
    story.append(table([["Etapa", "Comportamiento"]] + pattern, [31 * mm, CONTENT_W - 31 * mm]))
    story.append(P("Contrato recomendado para nuevas acciones", "H2"))
    for item in [
        "Aceptar solamente el método HTTP esperado y devolver 405 para otros métodos.",
        "Validar tipos, longitudes, listas permitidas e identificadores antes de llegar a SQL.",
        "Aplicar autorización por acción en el servidor y protección CSRF en cambios de estado.",
        "Usar sentencias preparadas y respuestas JSON consistentes: éxito, datos, mensaje y código." ,
        "Registrar contexto técnico suficiente sin incluir contraseñas, tokens ni datos personales sensibles.",
    ]:
        story.append(bullet(item))
    story.append(PageBreak())

    # 7
    story += heading("07", "Modelo de datos conceptual", "Entidades centrales y relaciones funcionales observadas.")
    groups = [
        ["Área", "Tablas principales", "Relaciones conceptuales"],
        ["Inventario", "auto, autohistorico, autoventas, imagen", "Un auto tiene imágenes; el histórico y la venta conservan <b>id_previo</b>."],
        ["Catálogos", "marca, modelo, interiores, transmision", "Marca agrupa modelos; auto referencia los catálogos."],
        ["Personas", "cliente, clientes_banca, usuario, contactos, suscriptor", "Propietarios, compradores, operadores y prospectos."],
        ["Comercial", "venta, pago, pago_evento", "Una venta pertenece a un cliente y admite pagos y eventos."],
        ["Operación", "almacenes, inventario_dia, ventas_dia", "Ubicación, verificaciones y cortes operativos."],
        ["Seguimiento", "log_cambio_auto, log_envio_correo, visitasauto", "Trazabilidad de cambios, envíos y visitas."],
        ["Marketing", "car_hunter, publicaciones, notficaiones_s", "Preferencias de búsqueda, canales y avisos."],
        ["Sistema", "configuraciones", "Parámetros internos de comportamiento."],
    ]
    story.append(table(groups, [28 * mm, 58 * mm, CONTENT_W - 86 * mm]))
    story.append(P("Relaciones críticas", "H2"))
    relations = [
        ["Origen", "Cardinalidad", "Destino"],
        ["marca", "1 a N", "modelo"],
        ["auto", "N a 1", "marca, modelo, transmision, interiores, cliente y almacen"],
        ["auto", "1 a N", "imagen, visitas y registros de cambio"],
        ["venta", "N a 1", "clientes_banca y auto histórico"],
        ["venta", "1 a N", "pago y pago_evento"],
    ]
    story.append(table(relations, [43 * mm, 29 * mm, CONTENT_W - 72 * mm]))
    story.append(Spacer(1, 4 * mm))
    story.append(callout("Compatibilidad de esquema", "La tabla <b>notficaiones_s</b> conserva una grafía histórica. No debe renombrarse directamente en producción: se requiere migración, compatibilidad temporal y verificación de todas las referencias."))
    story.append(P("Integridad recomendada", "H2"))
    story.append(P("Mantener claves primarias e índices de consulta; documentar claves foráneas existentes o lógicas; ejecutar cambios dentro de transacciones cuando involucren venta, saldo o inventario; y conservar copias verificadas antes de toda migración."))
    story.append(PageBreak())

    # 8
    story += heading("08", "Instalación y configuración", "Procedimiento reproducible para un entorno local o servidor equivalente.")
    prereq = [
        ["Requisito", "Referencia"],
        ["PHP", "8.3 o superior, extensión mysqli habilitada."],
        ["Base de datos", "MariaDB/MySQL compatible; conexión con juego de caracteres utf8mb4."],
        ["Servidor web", "Apache/Laragon en el entorno observado; document root apuntando al proyecto."],
        ["Permisos", "Lectura del código y escritura solamente en directorios que reciban archivos o registros."],
        ["Integraciones", "Credenciales válidas de correo y redes sociales solo cuando se habiliten esas funciones."],
    ]
    story.append(table(prereq, [40 * mm, CONTENT_W - 40 * mm]))
    story.append(P("Secuencia de puesta en marcha", "H2"))
    steps = [
        "Copiar el proyecto en el document root y conservar la estructura de rutas.",
        "Crear <b>.env</b> en la raíz tomando <b>.env.example</b> como plantilla. No copiar valores desde otro entorno sin autorización.",
        "Crear o restaurar la base de datos correspondiente y asignar un usuario con privilegios mínimos necesarios.",
        "Completar las variables de base de datos y, si se usará el publicador, <b>FACEBOOK_ACCESS_TOKEN</b>.",
        "Ejecutar <b>admin/sql/optimizacion_indices.sql</b> sobre la base objetivo. El script usa índices repetibles cuando el motor lo permite.",
        "Confirmar que el servidor bloquea el acceso HTTP a <b>.env</b> y archivos de respaldo.",
        "Abrir la portada, el inventario, una ficha válida y el acceso administrativo; después revisar el registro de PHP y del servidor web.",
    ]
    for i, text in enumerate(steps, 1):
        story.append(P(f"<b>{i}.</b> {text}"))
    story.append(P("Comandos de comprobación", "H2"))
    commands = """php -v
php -l index.php
php -l admin/api/conectorBD.php
php -l admin/banca/api/conectorBD.php"""
    story.append(Table([[P(commands.replace("\n", "<br/>"), "HaroCode")]], colWidths=[CONTENT_W], style=[
        ("BACKGROUND", (0, 0), (-1, -1), LIGHT), ("BOX", (0, 0), (-1, -1), 0.5, LINE),
    ]))
    story.append(PageBreak())

    # 9
    story += heading("09", "Variables de entorno y conectividad", "Contrato de configuración sin incluir valores secretos.")
    env_rows = [
        ["Variable", "Uso", "Observación"],
        ["DB_HOST", "Servidor de base de datos.", "Nombre o IP accesible desde PHP."],
        ["DB_PORT", "Puerto TCP.", "Normalmente 3306; usar el asignado al entorno."],
        ["DB_DATABASE", "Esquema de la aplicación.", "Debe existir antes de iniciar."],
        ["DB_USERNAME", "Usuario de aplicación.", "Aplicar mínimo privilegio."],
        ["DB_PASSWORD", "Contraseña del usuario.", "Nunca registrar ni versionar."],
        ["DB_CHARSET", "Codificación de la conexión.", "Mantener <b>utf8mb4</b>."],
        ["FACEBOOK_ACCESS_TOKEN", "Token del publicador de Facebook.", "Rotar al vencer o ante exposición."],
    ]
    story.append(table(env_rows, [48 * mm, 54 * mm, CONTENT_W - 102 * mm]))
    story.append(P("Carga de configuración", "H2"))
    story.append(P("Los conectores de <b>admin/api/conectorBD.php</b> y <b>admin/banca/api/conectorBD.php</b> cargan <b>env.php</b> con rutas basadas en <b>__DIR__</b>. La conexión se crea al primer uso, se reutiliza dentro de la petición y configura utf8mb4. El publicador de Facebook solicita su token con <b>haroEnv('FACEBOOK_ACCESS_TOKEN')</b>."))
    story.append(P("Protección obligatoria", "H2"))
    for item in [
        "Mantener <b>.env</b> fuera del control de versiones; <b>.env.example</b> solo contiene nombres y valores de muestra.",
        "La regla actual de <b>.htaccess</b> bloquea archivos <b>.env*</b> en Apache/Laragon. En Nginx o IIS se debe crear una regla equivalente.",
        "No exponer errores mysqli al navegador. Registrar el detalle técnico en un destino no público.",
        "Separar credenciales por ambiente y rotarlas ante cualquier sospecha de filtración.",
    ]:
        story.append(bullet(item))
    story.append(Spacer(1, 3 * mm))
    story.append(callout("Acción crítica pendiente", "Se detectaron credenciales SMTP incrustadas en varios flujos de correo. Deben trasladarse a variables de entorno y rotarse, sin copiar sus valores a documentación ni registros."))
    story.append(PageBreak())

    # 10
    story += heading("10", "Optimización de consultas", "Cambios aplicados para conservar resultados con menos viajes y trabajo de base de datos.")
    optimizations = [
        ["Problema", "Solución aplicada", "Impacto"],
        ["Consultas N+1 al listar autos", "Carga adaptable por lote y caché de catálogos, propietarios e imágenes.", "Menos conexiones lógicas y latencia estable al crecer el inventario."],
        ["Pagos consultados por cada venta", "Saldos y totales agregados en la consulta principal; eventos recuperados por lote.", "La vista de ventas evita repetición por fila."],
        ["Estadísticas por mes", "Los 12 meses se agrupan en una sola consulta.", "De 12 consultas equivalentes a 1."],
        ["Autos sin publicación", "Uso de <b>NOT EXISTS</b> para excluir coincidencias.", "Plan de ejecución más directo y semántica clara."],
        ["Filtros en memoria", "Predicados trasladados a SQL.", "Se transfieren y procesan solo filas útiles."],
        ["Recuperación del último ID", "Uso de <b>insert_id</b> en lugar de <b>MAX(id)</b>.", "Evita carreras entre inserciones concurrentes."],
        ["Búsquedas y uniones", "17 índices incorporados mediante el script de optimización.", "Menor costo en filtros, relaciones y ordenamientos frecuentes."],
    ]
    story.append(table(optimizations, [42 * mm, 65 * mm, CONTENT_W - 107 * mm]))
    story.append(P("Resultados de referencia", "H2"))
    benchmark = [
        ["Caso", "Antes", "Después observado"],
        ["Listado de 128 autos", "Aproximadamente 0.095 s", "0.027 a 0.050 s"],
        ["Consulta de 66 ventas", "Aproximadamente 0.037 s", "0.002 a 0.009 s"],
    ]
    story.append(table(benchmark, [60 * mm, 50 * mm, CONTENT_W - 110 * mm]))
    story.append(P("Criterios de conservación", "H2"))
    story.append(P("Las optimizaciones se aceptaron solo después de comparar resultados funcionales. Se verificaron los mismos identificadores y orden de autos activos, además de los saldos de todas las ventas. Las cifras son referencias del entorno local, no un SLA de producción."))
    story.append(P("Regla para cambios futuros", "H2"))
    story.append(P("Medir primero, revisar el plan de ejecución, reducir filas y viajes, agregar índices selectivos y volver a comparar el conjunto completo de resultados. Evitar índices redundantes: cada índice acelera lecturas, pero añade costo a inserciones y actualizaciones."))
    story.append(PageBreak())

    # 11
    story += heading("11", "Validación y pruebas", "Evidencia disponible y conjunto mínimo de regresión.")
    validation = [
        ["Prueba", "Cobertura", "Resultado observado"],
        ["Lint PHP", "Archivos PHP directos de raíz y todo <b>admin/</b>.", "572 archivos, 0 fallas."],
        ["Nivel de errores", "Ejecución bajo PHP 8.5 con E_ALL como verificación adelantada.", "Sin errores sintácticos del alcance."],
        ["Conectores", "Conector general y conector de banca.", "Conexión correcta y charset utf8mb4."],
        ["Portada e inventario", "index.php e inventory-list.php.", "HTTP 200."],
        ["Detalle válido", "vehicle-details.php con auto existente.", "HTTP 200."],
        ["Detalle inválido", "Identificador con formato incorrecto.", "HTTP 400."],
        ["Administración", "login.php y admin/index.php.", "Login 200; índice redirige con 302 a banca."],
        ["Salida web", "Cuerpos de respuestas críticas.", "Sin warning, fatal error ni deprecated visible."],
    ]
    story.append(table(validation, [36 * mm, 67 * mm, CONTENT_W - 103 * mm]))
    story.append(P("Pruebas mínimas antes de publicar", "H2"))
    checks = [
        "Crear, editar, pausar, reactivar y consultar un auto con varias imágenes.",
        "Probar filtros combinados, paginación, detalle inexistente y caracteres acentuados.",
        "Iniciar y cerrar sesión; comprobar un usuario sin permiso y otro con permiso de banca.",
        "Registrar cliente, venta, pago y evento; verificar saldo y trazabilidad.",
        "Ejecutar formularios de contacto y Car Hunter en un ambiente de correo controlado.",
        "Confirmar que <b>/.env</b>, respaldos y registros no son descargables por HTTP.",
        "Revisar registros de PHP, servidor web y base de datos inmediatamente después de la prueba." ,
    ]
    for item in checks:
        story.append(bullet(item))
    story.append(PageBreak())

    # 12
    story += heading("12", "Operación y mantenimiento", "Rutinas para sostener disponibilidad, rendimiento y trazabilidad.")
    runbook = [
        ["Frecuencia", "Actividad", "Evidencia"],
        ["Diaria", "Revisar errores PHP/HTTP, tareas fallidas, espacio disponible y operaciones comerciales incompletas.", "Registro revisado y anomalías asignadas."],
        ["Semanal", "Verificar respaldos restaurables, colas de notificación, publicaciones e inventario no verificado.", "Prueba de restauración o muestra validada."],
        ["Mensual", "Analizar consultas lentas, crecimiento de tablas e índices; revisar usuarios y permisos.", "Reporte de tendencias y cambios aprobados."],
        ["Por versión", "Ejecutar lint, pruebas HTTP, flujo administrativo, respaldo y plan de reversión.", "Lista de verificación firmada."],
        ["Por incidente", "Preservar registros, limitar impacto, rotar secretos afectados y documentar causa raíz.", "Cronología, acciones y prevención."],
    ]
    story.append(table(runbook, [25 * mm, 91 * mm, CONTENT_W - 116 * mm]))
    story.append(P("Respaldo y restauración", "H2"))
    for item in [
        "Respaldar base de datos y archivos cargados con la misma marca temporal.",
        "Cifrar respaldos, limitar acceso y definir una retención acorde con datos personales y obligaciones del negocio.",
        "Probar restauraciones en un entorno aislado. Un respaldo no verificado no debe considerarse recuperable.",
        "Antes de migraciones, conservar un punto de retorno y documentar exactamente la versión de esquema y código.",
    ]:
        story.append(bullet(item))
    story.append(P("Monitoreo recomendado", "H2"))
    story.append(P("Registrar tiempos de respuesta p50/p95, tasa de errores 4xx/5xx, conexiones y consultas lentas, tamaño de tablas, fallas de correo/publicación y resultados de tareas programadas. Establecer alertas a partir de una línea base real, no de umbrales arbitrarios."))
    story.append(P("Despliegue seguro", "H2"))
    story.append(P("Separar ambientes; cargar secretos en el servidor; ejecutar migraciones e índices de forma controlada; validar rutas críticas; y habilitar la versión solo después del humo funcional. La reversión debe restaurar código y esquema compatibles."))
    story.append(PageBreak())

    # 13
    story += heading("13", "Seguridad y hoja de ruta", "Riesgos prioritarios y evolución recomendada.")
    roadmap = [
        ["Prioridad", "Hallazgo", "Acción recomendada"],
        ["P0", "Credenciales SMTP incrustadas en código.", "Mover a <b>.env</b> o gestor de secretos, rotar credenciales y verificar historial/versiones desplegadas."],
        ["P0", "Token de Facebook previamente incrustado.", "Ya se externalizó; completar la rotación del token en Meta y revocar el anterior."],
        ["P1", "Consultas SQL construidas por interpolación en varias rutas.", "Migrar gradualmente a sentencias preparadas, empezando por autenticación y escrituras."],
        ["P1", "Contraseñas tratadas con SHA-1 en código heredado.", "Adoptar <b>password_hash</b>/<b>password_verify</b> con actualización transparente al iniciar sesión."],
        ["P1", "Autorización y CSRF no uniformes entre endpoints.", "Centralizar guardas de sesión, permisos, método HTTP y tokens CSRF."],
        ["P2", "Versiones antiguas de Bootstrap/jQuery y complementos.", "Actualizar en una rama de compatibilidad con pruebas visuales y funcionales."],
        ["P2", "Graph API fijada a una versión antigua en el publicador.", "Planificar actualización, revisar permisos y probar en una aplicación de desarrollo."],
        ["P2", "Archivos duplicados o históricos activos en el árbol.", "Medir uso, elegir canónicos, archivar y retirar después de cubrir dependencias."],
        ["P3", "Respuestas de API no totalmente uniformes.", "Definir contrato JSON, códigos HTTP, validación y manejo de errores común."],
    ]
    row_bgs = {1: colors.HexColor("#F8D7DA"), 2: colors.HexColor("#F8D7DA")}
    story.append(table(roadmap, [22 * mm, 57 * mm, CONTENT_W - 79 * mm], row_bgs=row_bgs))
    story.append(P("Orden sugerido", "H2"))
    story.append(P("Primero rotar y externalizar secretos restantes. Después asegurar autenticación, escrituras y permisos. A continuación normalizar APIs y retirar duplicados. Finalmente abordar la actualización visual y de integraciones externas. Cada fase debe incluir métricas, pruebas y reversión."))
    story.append(Spacer(1, 4 * mm))
    story.append(callout("Principio rector", "Una mejora no está completa si cambia los resultados esperados, oculta un error o depende de un secreto dentro del repositorio.", PALE_GREEN))
    story.append(PageBreak())

    # 14
    story += heading("14", "Apéndice de referencia", "Archivos esenciales y lista de entrega para futuras versiones.")
    key_files = [
        ["Archivo", "Uso"],
        ["/.env.example", "Contrato de variables sin secretos."],
        ["/env.php", "Carga central de configuración."],
        ["/.htaccess", "Protección Apache de archivos de entorno."],
        ["/index.php", "Entrada pública principal."],
        ["/inventory-list.php", "Inventario filtrable y paginado."],
        ["/vehicle-details.php", "Ficha individual y respuestas 400/404."],
        ["/admin/api/conectorBD.php", "Conexión de datos administrativa."],
        ["/admin/banca/api/conectorBD.php", "Conexión de datos del módulo banca."],
        ["/admin/sql/optimizacion_indices.sql", "Índices de rendimiento aplicados."],
        ["/admin/posteadorFacebook.php", "Publicador que consume FACEBOOK_ACCESS_TOKEN."],
    ]
    story.append(table(key_files, [69 * mm, CONTENT_W - 69 * mm]))
    story.append(P("Lista de entrega", "H2"))
    delivery = [
        "Código PHP validado con la versión objetivo.",
        "Variables del ambiente completas y secretos fuera del código.",
        "Migraciones e índices ejecutados y registrados.",
        "Pruebas públicas, administrativas y de banca aprobadas.",
        "Registros sin errores nuevos y métricas comparadas contra la línea base.",
        "Respaldo restaurable y plan de reversión disponible.",
        "Cambios, riesgos conocidos y responsable de operación documentados.",
    ]
    for item in delivery:
        story.append(bullet(item))
    story.append(P("Glosario mínimo", "H2"))
    glossary = [
        ["Término", "Definición"],
        ["Auto activo", "Vehículo disponible para los flujos públicos según sus banderas de estado."],
        ["Consignación", "Vehículo administrado para venta con propietario asociado."],
        ["Banca", "Submódulo administrativo para ventas, pagos, saldos, clientes y almacenes."],
        ["Car Hunter", "Solicitud de búsqueda de un vehículo de acuerdo con preferencias del prospecto."],
        ["N+1", "Patrón en el que una consulta inicial provoca otra consulta por cada fila obtenida."],
        ["Smoke test", "Comprobación breve de que las rutas y operaciones críticas funcionan después de un cambio."],
    ]
    story.append(table(glossary, [35 * mm, CONTENT_W - 35 * mm]))
    story.append(Spacer(1, 6 * mm))
    story.append(P("Fin del documento", "Center"))
    return story


def main() -> None:
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    doc = BaseDocTemplate(
        str(OUTPUT),
        pagesize=A4,
        leftMargin=MARGIN_X,
        rightMargin=MARGIN_X,
        topMargin=MARGIN_TOP,
        bottomMargin=MARGIN_BOTTOM,
        title="Documentación general - Haro Seminuevos",
        author="Documentación técnica del proyecto",
        subject="Arquitectura, instalación, operación y mantenimiento",
        creator="ReportLab",
    )
    frame = Frame(
        MARGIN_X,
        MARGIN_BOTTOM,
        CONTENT_W,
        PAGE_H - MARGIN_TOP - MARGIN_BOTTOM,
        id="main",
        leftPadding=0,
        rightPadding=0,
        topPadding=0,
        bottomPadding=0,
    )
    doc.addPageTemplates([PageTemplate(id="all", frames=[frame], onPage=draw_page)])
    doc.build(build_story())
    print(OUTPUT)


if __name__ == "__main__":
    main()
