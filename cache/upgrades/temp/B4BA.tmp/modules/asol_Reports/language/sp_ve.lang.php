<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$mod_strings = array (

  'LBL_MODULE_NAME' => 'Informes',

  'LBL_REPORT_COMMON_BASE_NEEDED' => 'Debes instalar <b>AlineaSol Common Base</b> %[v] como mínimo para ejecutar este módulo.',
		
  'LBL_REPORT_REPORTS_ACTION' => 'Informes',
  'LBL_REPORT_CHECK_ACTION' => 'Validación AlineaSol Reports',
  'LBL_REPORT_CUSTOMIZE_ACTION' => 'Customización CSS',
  'LBL_REPORT_CONFIG_ACTION' => 'Configuración',

  'LBL_LIST_FORM_TITLE' => 'Listado de Informes',
  'LBL_SEARCH_FORM_TITLE' => 'Buscar Informe',

  'LBL_ASOL_REPORTS_PANEL_DESC' => 'Sección de Configuración de Informes AlineaSol',
  'LBL_ASOL_REPORTS_TITLE' => 'Informes AlineaSol',
  'LBL_REPORT_MODULE_HEADER_LABEL' => 'Módulo',
  'LBL_REPORT_CHART' => 'Gráfico del Informe',

  'LBL_REPORT_ID' => 'Id del Informe',
  'LBL_REPORT_NAME' => 'Nombre del Informe',
  'LBL_REPORT_MODULE' => 'Módulo del Informe',
  'LBL_REPORT_META' => 'Informe Meta',
  'LBL_REPORT_LAST_RUN' => 'Última Ejecución',
  'LBL_REPORT_PARENT_ID' => 'Id Padre',
  'LBL_REPORT_LAST_UPDATE' => 'Última Actualización',
  'LBL_REPORT_ASSIGNED_USER' => 'Usuario Asignado',
  'LBL_REPORT_SCOPE' => 'Ámbito del Informe',
  'LBL_REPORT_INITIAL_EXECUTION' => 'Ejecución inicial con valores por defecto',
  'LBL_REPORT_SAVE_SEARCH' => 'Guardar última búsqueda',
  'LBL_REPORT_AUTO_EXECUTE_LIMIT' => 'Límite de ejecución automática',
  'LBL_REPORT_TYPE' => 'Tipo de Informe',
  'LBL_REPORT_ASSIGNED_TO' => 'Asignado a',
  'LBL_REPORT_SELECT_FILE' => 'Selecciona un fichero para importar',
  'LBL_REPORT_DOMAIN' => 'Dominio del Informe',
  'LBL_REPORT_UNIQUE_DETAIL' => 'Sólo puedes usar un campo detallado por informe. ¿Quieres cambiarlo?',

  'LBL_REPORT_CALCULATION_MODE' => 'Modo de Cálculo',
  'LBL_REPORT_MULTI_QUERY' => 'Multiconsulta en Detallados',
  'LBL_REPORT_GROSS_EXECUTION' => 'Ejecución Bruta',
  'LBL_REPORT_TRUSTED_EXECUTION' => 'Ejecución Confiable',
  'LBL_REPORT_DISTINCT_STATEMENT' => 'Añadir Cláusula DISTINCT',
  'LBL_REPORT_SHORT_TERM_EXECUTION' => 'Ejecución de corta duración (en ejecución manual)',
		
  'LBL_REPORT_FIELD_MANAGEMENT' => 'Gestión de Campos',
  'LBL_REPORT_DELETED_USAGE' => 'Uso de Eliminados',
		
  'LBL_REPORT_PAGINATION_MANAGEMENT' => 'Gestión de Paginado',
  'LBL_REPORT_PAGINATION_USAGE' => 'Uso de Paginado',
  'LBL_REPORT_PAGINATION_ENTRIES' => 'Entradas por Página',
		
  'LBL_REPORT_DATA_PRESENTATION' => 'Presentación de Datos',
  'LBL_REPORT_EXPAND_GROUPED_TOTALS' => 'Expandir Totales Agrupados',
  'LBL_REPORT_CLEAN_UP_STYLING' => 'Limpiar Estilo',
  'LBL_REPORT_LIGHT_WEIGHT_HTML' => 'HTML Ligero',
		
  'LBL_REPORT_AUDIT_TABLE' => 'Audit',
  'LBL_REPORT_AUTOREFRESH' => 'Refrescar',

  'LBL_REPORT_PAGINATION_PAGE' => 'Página',
  'LBL_REPORT_PAGINATION_OF' => 'de',

  'MSG_REPORT_DELETE_ALERT' => 'Está seguro de que quiere eliminar este informe?',

  'LBL_REPORT_RUN' => 'Ejecutar',
  'LBL_REPORT_SHOW' => 'Mostrar',
  'LBL_REPORT_COPY' => 'Copiar',
  'LBL_REPORT_SEARCH' => 'Buscar',
  'LBL_REPORT_CREATE' => 'Crear',
  'LBL_REPORT_CREATE_META' => 'Crear Meta',
  'LBL_REPORT_EDIT' => 'Editar',
  'LBL_REPORT_EXPORT_ONE' => 'Exportar',

  'LBL_REPORT_IMPORT' => 'Importar Informes',
  'LBL_REPORT_EXPORT' => 'Exportar Informes',
  'LBL_REPORT_MULTIDELETE' => 'Eliminar Informes',
  'LBL_REPORT_MULTIDELETE_ALERT' => 'Está seguro de que quiere eliminar estos informes?',
  'LBL_REPORT_UNDELETABLE_ALERT' => 'Más de un informe no podrá ser eliminado.',

  'LBL_REPORT_SEARCH_CRITERIA' => 'Criterio de Búsqueda',
  'LBL_REPORT_RESULTS' => 'Resultados del Informe',
  'LBL_REPORT_NO_RESULTS' => 'No hay resultados',
  'LBL_REPORT_MYSQL_ERROR' => 'Error de MySQL',
  'LBL_REPORT_API_ERROR' => 'Error de Api',
  'LBL_REPORT_TABLE' => 'Tabla',
  'LBL_REPORT_TOTALS' => 'Totales',
  'LBL_REPORT_TITLES' => 'Títulos',
  'LBL_REPORT_TITLE' => 'Titulo del Informe',
  'LBL_REPORT_HEADERS' => 'Cabeceras',
  'LBL_REPORT_SUBTOTALS' => 'Subtotales',
  'LBL_REPORT_CHARTS' => 'Gráficos del Informe',

  'LBL_REPORT_PAGINATION' => 'Paginado',
  'LBL_REPORT_PAGINATION_ALL' => 'Todos',
  'LBL_REPORT_PAGINATION_TOP' => 'Superior',
  'LBL_REPORT_PAGINATION_BOTTOM' => 'Inferior',

  'LBL_REPORT_CHARTS_ENGINE' => 'Motor Gráfico',
  'LBL_REPORT_CHART_ENGINE_NVD3' => 'NVD3',
  'LBL_REPORT_CHART_ENGINE_HTML5' => 'HTML5',
  'LBL_REPORT_CHART_ENGINE_FLASH' => 'Flash',
  'LBL_REPORT_CHARTS_MAP' => 'Mapas',
  'LBL_REPORT_CHARTS_GROUP_CIRCLES' => 'Circulares',
  'LBL_REPORT_CHARTS_GROUP_BARS' => 'Barras',
  'LBL_REPORT_CHARTS_GROUP_AREAS' => 'Líneas y áreas',
  'LBL_REPORT_CHARTS_GROUP_OTHERS' => 'Otros',
		
		
  'LBL_REPORT_REFRESH' => 'Actualizar',
  'LBL_REPORT_EXPORT_HTML' => 'Exportar a HTML',
  'LBL_REPORT_EXPORT_PDF' => 'Exportar a PDF',
  'LBL_REPORT_EXPORT_CSV' => 'Exportar a CSV',
  'LBL_REPORT_EXPORT_CLEAN_CSV' => 'Exportar a CSV Limpio',
  'LBL_REPORT_SEND_EMAIL' => 'Enviar por Email',
  'LBL_REPORT_SEND_APP' => 'Enviar a Aplicación',
  'LBL_REPORT_SEND_FTP' => 'Enviar a FTP',
  'LBL_REPORT_SEND_TL' => 'Enviar a Target List',
  'MSG_REPORT_SEND_EMAIL_ALERT' => 'Est&aacute; seguro de enviar este Email a los siguientes destinatarios?',

  'LBL_REPORT_FILE_FORMAT' => 'Formato del Fichero Generado',
  'LBL_REPORT_FILE_NAME' => 'Nombre del Fichero Generado',
  'LBL_REPORT_FILE_SEPARATOR' => 'Separador CSV',
  'LBL_REPORT_FILE_MASSIVE' => 'Generación de Fichero Masivo',
  'LBL_REPORT_ENCODING' => 'Tipo de codificación',
  'LBL_REPORT_BOM' => 'Bom para UTF-8',
  'LBL_REPORT_DESCRIPTION' => 'Descripción del Informe',
  'LBL_REPORT_INTERNAL_DESCRIPTION' => 'Descripción Interna',
  'LBL_REPORT_PUBLIC_DESCRIPTION' => 'Descripción Pública',
  'LBL_REPORT_DISPLAY_OPTS' => 'Mostrar',

  'LBL_REPORT_ALL' => 'Todos',
  'LBL_REPORT_LIMIT' => 'Limitar',
  'LBL_REPORT_MANUAL' => 'Manual',
  'LBL_REPORT_INTERNAL' => 'Uso Interno',
  'LBL_REPORT_EXTERNAL' => 'Uso Externo',
  'LBL_REPORT_SCHEDULED' => 'Programado',
  'LBL_REPORT_STORED' => 'Sólo Programado',
  'LBL_REPORT_WEBSERVICE_SOURCE' => 'Nube (fuente)',
  'LBL_REPORT_WEBSERVICE_REMOTE' => 'Nube (remoto)',
  'LBL_REPORT_PRIVATE' => 'Privado',
  'LBL_REPORT_PUBLIC' => 'Público',
  'LBL_REPORT_ROLE' => 'Rol',

  'LBL_REPORT_HTML' => 'HTML', 
  'LBL_REPORT_PDF' => 'PDF', 
  'LBL_REPORT_CSV' => 'CSV', 
  'LBL_REPORT_CSV_CLEAN' => 'CSV Limpio',
  'LBL_REPORT_XLS' => 'XLS', 
  'LBL_REPORT_XLS_CLEAN' => 'XLS Limpio',

  'LBL_REPORT_SCHEDULED_EMAIL' => 'Enviar Email',
  'LBL_REPORT_SCHEDULED_APP' => 'Enviar a Aplicación',
  'LBL_REPORT_SCHEDULED_FTP' => 'Enviar a FTP',
  'LBL_REPORT_SCHEDULED_TL' => 'Enviar a Target List',

  'LBL_REPORT_DISPLAY_TABLE' => 'Sólo Tabla',
  'LBL_REPORT_DISPLAY_TABLECHART' => 'Tabla y Gráficos',
  'LBL_REPORT_DISPLAY_CHARTTABLE' => 'Gráficos y Tabla',
  'LBL_REPORT_DISPLAY_CHART' => 'Sólo Gráficos',

  'LBL_REPORT_EMAIL_LINK' => 'Enlace al Informe desde Email',
  'LBL_REPORT_EMAIL_LINK_EXPLAIN' => 'para descargar informes programados con gráficos',

  'LBL_REPORT_FIELDS_FILTERS' => 'Campos y Filtros',
  'LBL_REPORT_SCHEDULED_TASKS' => 'Tareas Programadas',
  'LBL_REPORT_DISTRIBUTION_LIST' => 'Listado de Distribución',

  'LBL_REPORT_BASIC_INFO' => 'Datos Generales',
  'LBL_REPORT_FIELDS' => 'Campos',
  'LBL_REPORT_ADD_FIELDS' => 'Añadir Campos',
  'LBL_REPORT_RELATED_FIELDS' => 'Campos Relacionados',
  'LBL_REPORT_ADD_RELATED_FIELDS' => 'Añadir Campos Relacionados',
  'LBL_REPORT_SHOW_RELATED' => 'Mostrar Relación',
  'LBL_REPORT_SHOW_SECOND_RELATED' => 'Mostrar 2ª Relación',
  'LBL_REPORT_SHOW_BREADCRUMBS' => 'Ruta de Navegación',
  'LBL_REPORT_COLUMNS' => 'Campos',
  'LBL_REPORT_FILTERS' => 'Filtros',

  'LBL_REPORT_DATABASE' => 'Base de Datos',
  'LBL_REPORT_DATABASE_FIELD' => 'Campos de Base de Datos',
  'LBL_REPORT_ALIAS' => 'Alias',
  'LBL_REPORT_FIELD_REF' => 'Referencia',
  'LBL_REPORT_SORT_DIRECTION' => 'Dirección',
  'LBL_REPORT_FUCTION' => 'Función',
  'LBL_REPORT_GROUP_BY_LAYOUT' => 'Agrupación de Datos',

  'LBL_REPORT_FORMAT_TYPE' => 'Tipo Formato',

  'LBL_REPORT_OPERATOR' => 'Operador',
  'LBL_REPORT_FILTER_REF' => 'Referencia',

  'LBL_REPORT_FILTER_APPLY' => 'Aplicar',
  'LBL_REPORT_FILTER_NOAPPLY' => 'No Aplicar',
  'LBL_REPORT_BEHAVIOR' => 'Comportamiento',
  'LBL_REPORT_USER_INPUT_OPTS' => 'Opciones de Usuario',
  'LBL_REPORT_USER_INPUT_GENERATE' => 'Generar Valores Enumerado',
  'LBL_REPORT_AUTO' => 'Auto',
  'LBL_REPORT_VISIBLE' => 'Visible',
  'LBL_REPORT_HIDDEN' => 'Oculto',
  'LBL_REPORT_HTML_HIDDEN' => 'HTML Oculto',
  'LBL_REPORT_USER_INPUT' => 'Entrada de Usuario',
  'LBL_REPORT_FULL_CHART' => 'Gráfico Completo',
  'LBL_REPORT_HALF_CHART' => 'Medio Gráfico',

  'LBL_REPORT_FIRST_PARAMETER' => 'Primer Parámetro',
  'LBL_REPORT_SECOND_PARAMETER' => 'Segundo Parámetro',

  'LBL_REPORT_ADD_FILTER' => 'Añadir Filtro',
  'LBL_REPORT_DELETE_ROW' => 'Eliminar Campo',
  'LBL_REPORT_MULTIDELETE_ROW' => 'Eliminar Campos',
  'LBL_REPORT_ROW_UP' => 'Fila Arriba',
  'LBL_REPORT_ROW_DOWN' => 'Fila Abajo',

  'LBL_REPORT_DELETE_FILTER' => 'Eliminar Filtro',
  'LBL_REPORT_MULTIDELETE_FILTER' => 'Eliminar Filtros',
  'LBL_REPORT_FILTER_UP' => 'Filtro Arriba',
  'LBL_REPORT_FILTER_DOWN' => 'Filtro Abajo',

  'LBL_REPORT_ADD_SUBCHART' => 'Añadir Subgráfico',
  'LBL_REPORT_CONFIG_CHART' => 'Configurar Gráfico',
  'LBL_REPORT_DELETE_CHART' => 'Eliminar Gráfico',
  'LBL_REPORT_MULTIDELETE_CHART' => 'Eliminar Gráficos',

  'LBL_REPORT_ADD_CHART' => 'Añadir Nuevo Gráfico',
  'LBL_REPORT_CHARTS_TITLE' => 'Gráficos',
  'LBL_REPORT_CHARTS_NAME' => 'Nombre del Gráfico',
  'LBL_REPORT_CHARTS_REF' => 'Referencia',
  'LBL_REPORT_CHARTS_X_AXIS' => 'Eje X',
  'LBL_REPORT_CHARTS_Y_AXIS' => 'Eje Y',
  'LBL_REPORT_CHARTS_Z_AXIS' => 'Eje Z',
  'LBL_REPORT_CHARTS_LEFT_AXIS' => 'Eje Izquierdo',
  'LBL_REPORT_CHARTS_RIGHT_AXIS' => 'Eje Derecho',
  'LBL_REPORT_CHARTS_FUNCTION' => 'Función del Gráfico',
  'LBL_REPORT_CHARTS_TYPE' => 'Tipo de Gráfico',
  'LBL_REPORT_CHARTS_PIE' => 'Gráfico de Tarta',
  'LBL_REPORT_CHARTS_DONUT' => 'Gráfico de Donut',
  'LBL_REPORT_CHARTS_BAR' => 'Gráfico de Barras',
  'LBL_REPORT_CHARTS_STACK' => 'Gráfico Apilado Agrupado',
  'LBL_REPORT_CHARTS_HORIZONTAL' => 'Gráfico Horizontal Agrupado',
  'LBL_REPORT_CHARTS_LINE' => 'Gráfico de Líneas',
  'LBL_REPORT_CHARTS_SCATTER' => 'Gráfico de Dispersión',
  'LBL_REPORT_CHARTS_AREA' => 'Gráfico de Áreas Apiladas',
  'LBL_REPORT_CHARTS_FUNNEL' => 'Gráfico de Embudo',
  'LBL_REPORT_CHARTS_BUBBLE' => 'Gráfico de Burbujas',
  'LBL_REPORT_CHARTS_PARALLEL' => 'Gráfico Coordenadas Paralelas',

  'LBL_REPORT_TASKS' => 'Tareas',
  'LBL_REPORT_TASK_NAME' => 'Nombre de Tarea',
  'LBL_REPORT_EXECUTION_RANGE' => 'Rango de Ejecución',
  'LBL_REPORT_TASK_CRON_MODE' => 'Modo Cron',
  'LBL_REPORT_TASK_CRON_SYNTAX' => 'Sintaxis Cron',
  'LBL_REPORT_EXECUTION_NEXT_EXECUTION' => 'Próxima Ejecución',
  'LBL_REPORT_DAY_VALUE' => 'Día',
  'LBL_REPORT_TIME_VALUE' => 'Hora',
  'LBL_REPORT_EXECUTION_END_DATE' => 'Día de Finalización de Ejecución',
  'LBL_REPORT_TASK_STATE' => 'Estado de Tarea',
  'LBL_REPORT_ADD_TASK' => 'Añadir Nueva Tarea',
  'LBL_REPORT_DELETE_TASK' => 'Eliminar Tarea',
  'LBL_REPORT_MULTIDELETE_TASK' => 'Eliminar Tareas',
  'LBL_REPORT_DELETE_URL_PARAM' => 'Eliminar Parámetro de Url',
  'LBL_REPORT_MULTIDELETE_URL_PARAM' => 'Eliminar Parámetros de Url',

  'LBL_REPORT_EMAIL_LIST' => 'Listado de Emails',
  'LBL_REPORT_EMAIL_LIST_TIP' => 'Escribe una lista de emails separados por comas',
  'LBL_REPORT_BLIND_COPY_LIST' => 'Copia Oculta',
  'LBL_REPORT_BLIND_COPY' => 'CCO',

  'LBL_REPORT_DELETE_ROW_ALERT' => 'Está seguro de que quiere eliminar este campo?',
  'LBL_REPORT_DELETE_FILTER_ALERT' => 'Está seguro de que quiere eliminar este filtro?',
  'LBL_REPORT_DELETE_CHART_ALERT' => 'Está seguro de que quiere eliminar este gráfico?',
  'LBL_REPORT_DELETE_TASK_ALERT' => 'Está seguro de que quiere eliminar esta tarea?',
  'LBL_REPORT_DELETE_URL_PARAM_ALERT' => 'Está seguro de que quiere eliminar este parámetro de Url?',

  'LBL_REPORT_MULTIDELETE_ROW_ALERT' => 'Está seguro de que quiere eliminar estos campos?',
  'LBL_REPORT_MULTIDELETE_FILTER_ALERT' => 'Está seguro de que quiere eliminar estos filtros?',
  'LBL_REPORT_MULTIDELETE_CHART_ALERT' => 'Está seguro de que quiere eliminar estos gráficos?',
  'LBL_REPORT_MULTIDELETE_TASK_ALERT' => 'Está seguro de que quiere eliminar estas tareas?',
  'LBL_REPORT_MULTIDELETE_URL_PARAM_ALERT' => 'Está seguro de que quiere eliminar estos parámetros de Url?',

  'LBL_REPORT_INVALID_EMAIL_ALERT' => 'no es un email válido',

  'LBL_REPORT_MYSQL_NON_ADMIN_INSECURITY' => 'No tienes permisos para definir subConsultas MySQL como una función del campo mySQL',
  'LBL_REPORT_PHP_NON_ADMIN_INSECURITY' => 'No se puede utilizar esta función PHP: ',

  'LBL_REPORT_SENDING_EMAILS' => 'Enviando Emails...',
  'LBL_REPORT_SENDING_TO_APP' => 'Enviando a Aplicación...',
  'LBL_REPORT_SENDING_TO_FTP' => 'Enviando a FTP...',
  'LBL_REPORT_SENDING_TO_TL' => 'Enviando a Target List...',
  'LBL_REPORT_LOADING' => 'Cargando Informe...',
  'LBL_REPORT_WAITING' => 'En Cola de Ejecución...',
  'LBL_REPORT_TIMEOUT' => 'Tiempo Expirado. Inténtelo de nuevo más tarde...',
  'LBL_REPORT_LOADING_DATA' => 'Cargando Datos...',
  'LBL_REPORT_SAVING_DATA' => 'Guardando Datos...',
  'LBL_REPORT_DOWNLOAD_REPORT' => 'Descargar Informe',

  'LBL_REPORT_FLASH_WARNING' => 'Instala o actualiza el plugin de flash',

  'LBL_REPORT_EMAIL_TTL_TEXT_1' => 'Haga Click Aquí',
  'LBL_REPORT_EMAIL_TTL_TEXT_2' => 'para ver y descargar el informe con imágenes',
  'LBL_REPORT_ALT_EMAIL_TTL_TEXT' => 'URL para ver y descargar el informe con imágenes',

  'LBL_REPORT_EMAIL_AVAILABLE_TEXT_1' => 'El informe con imágenes estará disponible para su descarga durante un periodo de',
  'LBL_REPORT_EMAIL_AVAILABLE_TEXT_2' => 'días después de su generación.',

  'LBL_REPORT_NOT_AVAILABLE' => 'El informe que ha solicitado no está disponible',
  
  'LBL_REPORT_MONTHLY' => 'Mensual',
  'LBL_REPORT_WEEKLY' => 'Semanal',
  'LBL_REPORT_DAILY' => 'Diario',
  'LBL_REPORT_ACTIVE' => 'Activo',
  'LBL_REPORT_INACTIVE' => 'Inactivo',
  
  'LBL_REPORT_MONDAY' => 'Lunes',
  'LBL_REPORT_TUESDAY' => 'Martes',
  'LBL_REPORT_WEDNESDAY' => 'Miércoles',
  'LBL_REPORT_THURSDAY' => 'Jueves',
  'LBL_REPORT_FRIDAY' => 'Viernes',
  'LBL_REPORT_SATURDAY' => 'Sábado',
  'LBL_REPORT_SUNDAY' => 'Domingo',

  'LBL_REPORT_JANUARY' => 'Enero',
  'LBL_REPORT_FEBRUARY' => 'Febrero',
  'LBL_REPORT_MARCH' => 'Marzo',
  'LBL_REPORT_APRIL' => 'Abril',
  'LBL_REPORT_MAY' => 'Mayo',
  'LBL_REPORT_JUNE' => 'Junio',
  'LBL_REPORT_JULY' => 'Julio',
  'LBL_REPORT_AUGUST' => 'Agosto',
  'LBL_REPORT_SEPTEMBER' => 'Septiembre',
  'LBL_REPORT_OCTOBER' => 'Octubre',
  'LBL_REPORT_NOVEMBER' => 'Noviembre',
  'LBL_REPORT_DECEMBER' => 'Diciembre',

  'LBL_REPORT_CALENDAR' => 'Calendario',
  'LBL_REPORT_DAYOFWEEK' => 'Día de la Semana',
  'LBL_REPORT_WEEKOFYEAR' => 'Semana del Año',
  'LBL_REPORT_MONTHOFYEAR' => 'Mes del Año',
  'LBL_REPORT_NATURALQUARTEROFYEAR' => 'Trimestre Natural del Año',
  'LBL_REPORT_FISCALQUARTEROFYEAR' => 'Trimestre Fiscal del Año',
  'LBL_REPORT_NATURALYEAR' => 'Año Natural',
  'LBL_REPORT_FISCALYEAR' => 'Año Fiscal',

  
  'LBL_REPORT_YES' => 'Si',
  'LBL_REPORT_NO' => 'No',
  'LBL_REPORT_GROUPED' => 'Agrupado',
  'LBL_REPORT_MINUTE_GROUPED' => 'Agrupado por Minuto',
  'LBL_REPORT_QHOUR_GROUPED' => 'Agrupado por Cuarto de Hora',
  'LBL_REPORT_HOUR_GROUPED' => 'Agrupado por Hora',
  'LBL_REPORT_DAY_GROUPED' => 'Agrupado por Día',
  'LBL_REPORT_DOW_GROUPED' => 'Agrupado por Día de la Semana',
  'LBL_REPORT_WOY_GROUPED' => 'Agrupado por Semana del Año',
  'LBL_REPORT_MONTH_GROUPED' => 'Agrupado por Mes',
  'LBL_REPORT_NQUARTER_GROUPED' => 'Agrupado por Trimestre Natural',
  'LBL_REPORT_FQUARTER_GROUPED' => 'Agrupado por Trimestre Fiscal', 
  'LBL_REPORT_NYEAR_GROUPED' => 'Agrupado por Año Natural',
  'LBL_REPORT_FYEAR_GROUPED' => 'Agrupado por Año Fiscal',

  'LBL_REPORT_DETAIL' => 'Detallado',
  'LBL_REPORT_MINUTE_DETAIL' => 'Detallado por Minuto',
  'LBL_REPORT_QHOUR_DETAIL' => 'Detallado por Cuarto de Hora',
  'LBL_REPORT_HOUR_DETAIL' => 'Detallado por Hora',
  'LBL_REPORT_DAY_DETAIL' => 'Detallado por Día',
  'LBL_REPORT_DOW_DETAIL' => 'Detallado por Día de la Semana',
  'LBL_REPORT_WOY_DETAIL' => 'Detallado por Semana del Año',
  'LBL_REPORT_MONTH_DETAIL' => 'Detallado por Mes',
  'LBL_REPORT_NQUARTER_DETAIL' => 'Detallado por Trimestre Natural',
  'LBL_REPORT_FQUARTER_DETAIL' => 'Detallado por Trimestre Fiscal',
  'LBL_REPORT_NYEAR_DETAIL' => 'Detallado por Año Natural',
  'LBL_REPORT_FYEAR_DETAIL' => 'Detallado por Año Fiscal',

  'LBL_REPORT_SORT' => 'Dirección de Ordenado',
  'LBL_REPORT_ASC_SORT' => 'Ordenado Ascendente',
  'LBL_REPORT_DESC_SORT' => 'Ordenado Descendente',

  'LBL_REPORT_UNAVAILABLE' => 'No Disponible',
  
  'LBL_REPORT_EQUALS' => 'Igual a',
  'LBL_REPORT_NOT_EQUALS' => 'Distinto de',
  'LBL_REPORT_LIKE' => 'Contiene',
  'LBL_REPORT_NOT_LIKE' => 'No Contiene',
  'LBL_REPORT_STARTS_WITH' => 'Empieza por',
  'LBL_REPORT_ENDS_WITH' => 'Termina con',
  'LBL_REPORT_MY_ITEMS' => 'Mis Elementos',
  'LBL_REPORT_INHERIT' => 'Heredar',
  'LBL_REPORT_ONE_OF' => 'Uno Igual a',
  'LBL_REPORT_NOT_ONE_OF' => 'Uno Distinto de',
  'LBL_REPORT_BEFORE_DATE' => 'Anterior a',
  'LBL_REPORT_AFTER_DATE' => 'Posterior a',
  'LBL_REPORT_BETWEEN' => 'Entre',
  'LBL_REPORT_NOT_BETWEEN' => 'No Entre',
  'LBL_REPORT_LAST' => 'Últimos',
  'LBL_REPORT_NOT_LAST' => 'No Últimos',
  'LBL_REPORT_THIS' => 'Este',
  'LBL_REPORT_NOT_THIS' => 'No Este',
  'LBL_REPORT_THESE' => 'Estos',
  'LBL_REPORT_NEXT' => 'Próximo',
  'LBL_REPORT_NOT_NEXT' => 'No Próximo',
  
  'LBL_REPORT_LESS_THAN' => 'Menor Que',
  'LBL_REPORT_MORE_THAN' => 'Mayor Que',
  'LBL_REPORT_DAY' => 'Día(s)',
  'LBL_REPORT_WEEK' => 'Semana(s)',
  'LBL_REPORT_MONTH' => 'Mes(es)',
  'LBL_REPORT_FQUARTER' => 'Trimestre(s) Fiscal(es)',
  'LBL_REPORT_NQUARTER' => 'Trimestre(s) Natural(es)',
  'LBL_REPORT_FYEAR' => 'Año(s) Fiscal(es)',
  'LBL_REPORT_NYEAR' => 'Año(s) Natural(es)',
  'LBL_REPORT_TRUE' => 'Verdadero',
  'LBL_REPORT_FALSE' => 'Falso',
  
  'LBL_REPORT_NAMELESS' => 'Sin Nombre',

  'LBL_REPORT_FIRST_RESULTS' => 'Primeros n resultados',
  'LBL_REPORT_LAST_RESULTS' => 'Últimos n resultados',

  //Search Criteria Labels
  'LBL_REPORT_THIS_DAY' => 'Hoy',
  'LBL_REPORT_NOT_THIS_DAY' => 'No Hoy',
  'LBL_REPORT_LAST_DAY' => 'Ayer',
  'LBL_REPORT_LAST_DAY_1' => 'Ayer',
  'LBL_REPORT_NOT_LAST_DAY' => 'No Ayer',
  'LBL_REPORT_NOT_LAST_DAY_1' => 'No Ayer',
  'LBL_REPORT_NEXT_DAY' => 'Mañana',
  'LBL_REPORT_NEXT_DAY_1' => 'Mañana',
  'LBL_REPORT_NOT_NEXT_DAY' => 'No Mañana',
  'LBL_REPORT_NOT_NEXT_DAY_1' => 'No Mañana',
  
  'LBL_REPORT_LAST_MONDAY' => 'Pasado Lunes',
  'LBL_REPORT_LAST_TUESDAY' => 'Pasado Martes',
  'LBL_REPORT_LAST_WEDNESDAY' => 'Pasado Miércoles',
  'LBL_REPORT_LAST_THURSDAY' => 'Pasado Jueves',
  'LBL_REPORT_LAST_FRIDAY' => 'Pasado Viernes',
  'LBL_REPORT_LAST_SATURDAY' => 'Pasado Sábado',
  'LBL_REPORT_LAST_SUNDAY' => 'Pasado Domingo',
  
  'LBL_REPORT_THIS_MONTH' => 'Este Mes',
  'LBL_REPORT_LAST_JANUARY' => 'Pasado Enero',
  'LBL_REPORT_LAST_FEBRUARY' => 'Pasado Febrero',
  'LBL_REPORT_LAST_MARCH' => 'Pasado Marzo',
  'LBL_REPORT_LAST_APRIL' => 'Pasado Abril',
  'LBL_REPORT_LAST_MAY' => 'Pasado Mayo',
  'LBL_REPORT_LAST_JUNE' => 'Pasado Junio',
  'LBL_REPORT_LAST_JULY' => 'Pasado Julio',
  'LBL_REPORT_LAST_AUGUST' => 'Pasado Agosto',
  'LBL_REPORT_LAST_SEPTEMBER' => 'Pasado Septiembre',
  'LBL_REPORT_LAST_OCTOBER' => 'Pasado Octubre',
  'LBL_REPORT_LAST_NOVEMBER' => 'Pasado Noviembre',
  'LBL_REPORT_LAST_DECEMBER' => 'Pasado Diciembre',

  'LBL_REPORT_ROW_INDEX' => 'Índice de fila',
  'LBL_REPORT_RESULTS' => 'Resultados',

  'LBL_REPORT_FIRST_NATURAL_QUARTER' => 'T1',
  'LBL_REPORT_SECOND_NATURAL_QUARTER' => 'T2',
  'LBL_REPORT_THIRD_NATURAL_QUARTER' => 'T3',
  'LBL_REPORT_FORTH_NATURAL_QUARTER' => 'T4',
  
  'LBL_REPORT_FIRST_FISCAL_QUARTER' => 'TF1',
  'LBL_REPORT_SECOND_FISCAL_QUARTER' => 'TF2',
  'LBL_REPORT_THIRD_FISCAL_QUARTER' => 'TF3',
  'LBL_REPORT_FORTH_FISCAL_QUARTER' => 'TF4',
  
  'LBL_REPORT_CHARTS_VALUE_SIZE_K' => 'Valores representados en Miles',
  'LBL_REPORT_CHARTS_VALUE_SIZE_M' => 'Valores representados en Millones',
		
  'LBL_REPORT_DATA_SOURCE' => 'Origen de Datos',
  'LBL_REPORT_DATA_SOURCE_DB' => 'Base de Datos',
  'LBL_REPORT_DATA_SOURCE_API' => 'Api',

  'LBL_REPORT_MAX_ALLOWED_RESULTS_SUBJECT' => 'Se ha alcanzado el número límite de resultados permitido para el informe',
  'LBL_REPORT_MAX_ALLOWED_RESULTS_BODY1' => 'Se ha alcanzado el número límite de resultados permitido',
  'LBL_REPORT_MAX_ALLOWED_RESULTS_BODY2' => 'filas se han intentado procesar por SQL.',
  'LBL_REPORT_MAX_ALLOWED_RESULTS_BODY3' => 'Consulta ejecutada',
  'LBL_REPORT_MAX_ALLOWED_NOT_INDEXED_ORDERBY_ALERT' => 'Informe no ordenado: límite de tamaño superado.',
  'LBL_REPORT_OVERSIZED' => 'Demasiados resultados. Por favor, refine sus criterios de búsqueda.',

  'LBL_REPORT_MODIFIED_INHERIT_FILTERS' => 'Las referencias de filtros han sido modificadas. Comprueba tus filtros heredados en el editor de SubQueries.',

  'LBL_AUDIT_REPORT_PARENT_ID' => 'Asociada a',
  'LBL_AUDIT_REPORT_DATA_TYPE' => 'Tipo de Dato',

  'LBL_REPORT_AND' => 'Y',
  'LBL_REPORT_OR' => 'O',
  'LBL_REPORT_NOT' => 'No',
  'LBL_SHOW_LOGICAL_REPRESENTATION' => 'Mostrar Representación Lógica',
  'LBL_REPORT_LOGICAL_OPERATORS' => 'Op. Lógicos',
  'LBL_REPORT_MATCHING_PARENTHESIS_ALERT' => 'El número de parentesis de apertura y cierre no coinciden',
  'LBL_REPORT_LAST_FILTER_LOGICAL_LINK_ALERT' => 'El último filtro no puede tener ningún enlace lógico seleccionado',
  'LBL_REPORT_TWO_OR_MORE_DETAIL' => 'No puedes guardar más de un campo detallado. Por favor, revisa los campos antes de guardar el informe',
  'LBL_REPORT_GRAPH_FIELDS_ALERT' => 'Rellene los campos necesarios para el gráfico (o seleccione el modo no visible)',

  'LBL_REPORT_SAVE' => 'Guardar',
  'LBL_REPORT_SAVE_CONTINUE' => 'Guardar y Continuar',
  'LBL_REPORT_SAVE_PUSH' => 'Guardar y Publicar',
  'LBL_REPORT_CLEAR' => 'Limpiar',
  'LBL_REPORT_CLOSE' => 'Cerrar',
  'LBL_REPORT_CANCEL' => 'Cancelar',
  'LBL_REPORT_MAPPING' => 'Ver Mapeo MySQL',
  'LBL_REPORT_SHOWSQL' => 'Ver SQL',
  'LBL_REPORT_SQL_FUNCTION_FOR' => 'Función SQL para',
  'LBL_REPORT_PHP_FUNCTION_FOR' => 'Función PHP para',
  'LBL_REPORT_SQL_CODE' => 'Código SQL',
  'LBL_REPORT_PHP_CODE' => 'Código PHP',
  'LBL_CUSTOM_SCHEDULED_DISPLAY_CONFIGURATION' => 'Configuración de Visualización',
  'LBL_CUSTOM_SCHEDULED_HEADERS' => 'Suprimir Cabeceras',
  'LBL_CUSTOM_SCHEDULED_QUOTES' => 'Suprimir Comillas',
  'LBL_CUSTOM_SCHEDULED_DONOTSENDIFEMPTY' => 'No enviar email si el informe está vacío',
  'LBL_CUSTOM_SCHEDULED_POPUP' => 'Abrir Popup (ejecución manual)',
  'LBL_CUSTOM_SCHEDULED_APP_URL' => 'Url Aplicación',
  'LBL_CUSTOM_SCHEDULED_APP_POST_PARAMS' => 'Parámetros Post Aplicación',
  'LBL_CUSTOM_SCHEDULED_APP_FIXED_PARAMS' => 'Parámetros Fijos Aplicación',

  'LBL_CUSTOM_SCHEDULED_APP_ADD_NEW_PARAM' => 'Añadir Nuevo Parámetro',

  'LBL_CUSTOM_SCHEDULED_URL_PARAM' => 'Parámetro',
  'LBL_CUSTOM_SCHEDULED_URL_VALUE' => 'Valor',
  'LBL_CUSTOM_SCHEDULED_URL_DESC' => 'Descripción',

  'LBL_REPORT_APP_FIXED_DATA_DESCRIPTION' => 'Datos del Informe en Formato CSV',
  'LBL_REPORT_APP_FIXED_NAME_DESCRIPTION' => 'El nombre del Informe',
  'LBL_REPORT_APP_FIXED_TIME_DESCRIPTION' => 'Un Timestamp con Formato "YmdThis"',

  'LBL_CUSTOM_SCHEDULED_FTP_DATA' => 'Datos del FTP',
  'LBL_CUSTOM_SCHEDULED_FTP_SECURE_DATA' => 'Datos Cifrado Seguridad',
  'LBL_CUSTOM_SCHEDULED_FTP_HOST' => 'Dirección Host',
  'LBL_CUSTOM_SCHEDULED_FTP_PORT' => 'Puerto',
  'LBL_CUSTOM_SCHEDULED_FTP_SECURE' => 'Es Seguro?',
  'LBL_CUSTOM_SCHEDULED_FTP_ENCRYPTION' => 'Tipo Encriptación',
  'LBL_CUSTOM_SCHEDULED_FTP_PRIVATE_KEY' => 'Clave Privada',
  'LBL_CUSTOM_SCHEDULED_FTP_USERNAME' => 'Nombre de Usuario',
  'LBL_CUSTOM_SCHEDULED_FTP_PASSWORD' => 'Contraseña',
  'LBL_CUSTOM_SCHEDULED_FTP_PATH' => 'Ruta',
		
  'LBL_CUSTOM_SCHEDULED_TL_DATA' => 'Datos del Target List',
  'LBL_CUSTOM_SCHEDULED_TL_MODE' => 'Modo',
  'LBL_CUSTOM_SCHEDULED_TL_MODE_CREATE' => 'Crear',
  'LBL_CUSTOM_SCHEDULED_TL_MODE_UPDATE' => 'Actualizar',
  'LBL_CUSTOM_SCHEDULED_TL_VALUE' => 'Nombre del Target List',

  'LBL_REPORT_SCHEDULED_USER_INPUT_ALERT' => 'Los filtros tipo entrada de usuario NO son compatibles con los informes programados.\nEste informe no será ejecutado por el programador de tareas.',
  'LBL_REPORT_STORED_URI_INFO_DELETED_ALERT' => 'Hay datos almacenados en este Informe que se eliminarán.\n¿Estás seguro de cambiar el tipo de informe?',
  
  'LBL_REPORT_TEMPLATE_SELECTOR_HEADER' => 'Selecciona Plantilla',

  'LBL_REPORT_BUTTON_GENERATOR_TITLE_FOR' => 'Generador de Botones para',
  'LBL_REPORT_DROPDOWN_GENERATOR_TITLE_FOR' => 'Generador de Enumerados para',

  'LBL_REPORT_CHART_CONFIGURATOR_TITLE_FOR' => 'Configuración de Gráfico para',
  'LBL_REPORT_CHART_CONFIGURATOR_CUSTOM_COLOR_PALETTE' => 'Paleta Personalizada',
  'LBL_REPORT_CHART_CONFIGURATOR_DEFAULT_COLOR_PALETTE' => 'Paleta por Defecto',


  'LBL_REPORT_EXTERNAL_FILTER' => 'Filtros Externos',
  'LBL_REPORT_EXTERNAL_FILTER_REFERENCE' => 'Referencia',
  'LBL_REPORT_EXTERNAL_FILTER_VALUE' => 'Valor',
  'LBL_REPORT_DELETE_EXTERNAL_FILTER_ALERT' => 'Está seguro de que quiere eliminar este Filtro Externo?',


  'LBL_REPORT_DRAG_TO_MOVE' => 'clickea y arrastra para mover',


  'LBL_ASSIGNED_TO_ID' => 'Asignado a ID',
  'LBL_MODIFIED_NAME' => 'Nombre modificado',
  'LBL_REPORT_CHARTS_DETAIL' => 'Detalle del Gráfico del Informe',


  'LBL_REPORT_SEND_EMAIL_FROM' => 'De',
  'LBL_REPORT_SEND_EMAIL_ALL' => 'Resumen',
  'LBL_REPORT_SEND_EMAIL_ALL_TIP' => '(introducir datos en otros tabs)',
  'LBL_REPORT_SEND_EMAIL_TO' => 'Para',
  'LBL_REPORT_SEND_EMAIL_CC' => 'CC',
  'LBL_REPORT_SEND_EMAIL_BCC' => 'BCC',
  'LBL_REPORT_SEND_EMAIL_USERS' => 'Usuarios',
  'LBL_REPORT_SEND_EMAIL_ROLES' => 'Roles',

  'LBL_REPORT_NOT_FOUND' => 'El informe especificado no existe',

  'LBL_REPORT_TABLE_CONFIGURATION' => 'Configuración de la Tabla',
  'LBL_REPORT_FILTERS_CONFIGURATION' => 'Configuración de los Filtros',
  'LBL_REPORT_FIELD_ORDERING' => 'Ordenado de Campos',
  'LBL_REPORT_GROUP_ORDERING' => 'Ordenado de Agrupaciones',
  'LBL_REPORT_FIRST_ORDINAL_CHARACTER' => 'º',
  'LBL_REPORT_SECOND_ORDINAL_CHARACTER' => 'º',
  'LBL_REPORT_THIRD_ORDINAL_CHARACTER' => 'º',
  'LBL_REPORT_NTH_ORDINAL_CHARACTER' => 'º',

  'LBL_REPORT_VISIBILITY' => 'Visibilidad',

  'LBL_REPORT_FIELD_MULTILANGUAGE' => 'Gestión Multilingüe',

  'LBL_REPORT_ADDITIONAL_INFO' => 'Información Adicional',
  
  'LBL_REPORT_VARIABLE_REF' => 'Referencia de Variable',
  'LBL_REPORT_VARIABLE_COPIED' => 'Copiada al Portapapeles',

  'LBL_REPORT_FIELD_MULTIJOIN' => 'Gestión de SQL Joins',
  'LBL_REPORT_JOIN_SUBTITLE' => 'Incluír en el resultado si valor enlazado existe',
  'LBL_REPORT_JOIN_TYPE' => 'Tipo de Join',
  'LBL_REPORT_LINK_TABLE' => 'Tabla Link',
  'LBL_REPORT_JOIN_TABLE' => 'Tabla Join',
  'LBL_REPORT_JOIN_EXISTS' => 'Existe',
  'LBL_REPORT_MAIN_TABLE' => 'Tabla Principal',

  'LBL_REPORT_RELATE_MANAGEMENT_ACTION' => 'Gestión de Relaciones Virtuales',
  'LBL_REPORT_ADD_VIRTUAL_RELATION' => 'Añadir Nueva Relación',
  'LBL_REPORT_RELATION_NAME' => 'Nombre Relación',
  'LBL_REPORT_RELATION_DATABASE' => 'Base de Datos Relación',
  'LBL_REPORT_RELATION_MAIN_MODULE_FIELD' => 'Módulo/Campo Principal',
  'LBL_REPORT_RELATION_RELATION_MODULE_FIELD' => 'Módulo/Campo Relacionado',
  'LBL_REPORT_RELATION_RELATION_ROLES' => 'Ámbito de la Relación',
  'LBL_REPORT_DELETE_RELATION_ALERT' => 'Está seguro de que quiere eliminar esta Relación?',
	
  'LBL_REPORT_WEBSERVICE_MANAGEMENT_ACTION' => 'Sincronización con la Nube',
  'LBL_NO_WEBSERVICE_ACCESS' => 'Servicio no disponible temporalmente. Inténtelo de nuevo más tarde o contacte con el administrador.',

  'LBL_REPORT_CLEANUP_ALERT' => 'Los datos actuales van a ser eliminados',
  'LBL_REPORT_MAIN_EDITOR' => 'Informe Principal',
  'LBL_REPORT_SUB_EDITOR' => 'Sub-Informe',

  'LBL_REPORT_DYNAMIC_TABLES' => 'Tablas Dinámicas',
  'LBL_REPORT_DYNAMIC_TABLE_SQL' => 'SQL de Tabla Dinámica (RegExp)',
  'LBL_REPORT_DYNAMIC_TABLE_CANCEL' => 'Cancelar Tabla Dinámica',
  'LBL_REPORT_DYNAMIC_TABLE_SQL_TIP' => 'Usar expresiones regulares entrecomilladas (se permiten funciones SQL).',
  'LBL_REPORT_CHECK_MATCHING_TABLES' => 'Comprobar Tablas',
  'LBL_REPORT_DYNAMIC_TABLES_NO_MATCH' => 'Sin Coincidencias',
  'LBL_REPORT_DYNAMIC_TABLES_DIFFERENT_STRUCTURE' => 'Distintas Estructuras de Tabla',
  'LBL_REPORT_GET_MATCHING_FIELDS' => 'Obtener Campos',

  'LBL_REPORT_CSS_BUTTON' => 'CSS Informe',

  'LBL_REPORT_FIELD_SINGLE' => 'Simple',
  'LBL_REPORT_FIELD_INDEXED' => 'Indexado',
  'LBL_REPORT_FIELD_RELATION' => 'Relación',

  'LBL_REPORT_WHERE_FILTERS' => 'Filtros de Campo',
  'LBL_REPORT_HAVING_FILTERS' => 'Filtros de Función',
  'LBL_REPORT_ADD_TO_FILTER_PANEL' => 'Añadir a...',
  'LBL_REPORT_HAVING_FILTER_DELETE_ALERT' => 'Los "Filtros de Función" asociados serán eliminados. Quieres moverlos a "Filtros de Campo"?',

  'LBL_REPORT_META_HTML' => 'Definición HTML',

  'LBL_REPORT_ACTIVE_QUERY_ACTION' => 'Administración de Queries Activas',
  'LBL_REPORT_ACTIVE_QUERY_TITLE' => 'Queries Activas de Informes',
  'LBL_REPORT_ACTIVE_QUERY_KILLED_CONFIRM' => 'Query Abortada',
  'LBL_REPORT_ACTIVE_QUERY_KILL' => 'Abortar Query',
  'LBL_REPORT_ACTIVE_QUERY_KILLING' => 'Abortando Query',
		
  'LBL_REPORT_EXPORTED_CSS' => 'Página de estilos de los informes',
  'LBL_REPORT_EXPORT_ORIGINAL_CSS' => 'Exportar CSS Original',
  'LBL_REPORT_EXPORT_CUSTOM_CSS' => 'Exportar CSS personalizado',
  'LBL_REPORT_DOWNLOAD_CSS' => 'Descargar CSS Original',
  'LBL_REPORT_DOWNLOAD_CUSTOM_CSS' => 'Descargar CSS personalizado',
  'LBL_REPORT_EXPORT_CSS' => 'Exportar CSS',
  'LBL_REPORT_DOWNLOAD' => 'Descargar',
  'LBL_REPORT_RESTORE_CSS' => 'Restaurar CSS Original',
  'LBL_REPORT_RESTORE' => 'Restaurar',
  'LBL_REPORT_UPLOAD_CSS' => 'Subir CSS personalizado',
  'LBL_REPORT_UPLOAD' => 'Subir',
  
  'LBL_REPORT_DISPLAY_BUTTONS' => 'Visibilidad de Botones',
  'LBL_REPORT_SEARCH_BEHAVIOUR' => 'Comportamiento de Búsqueda',
  'LBL_REPORT_AVOID_TRIM_SEARCH' => 'Evitar recortar espacios en la búsqueda',
  'LBL_REPORT_AVOID_EMPTY_FILTERS' => 'Ignorar filtros en blanco',
  'LBL_REPORT_AVOID_AUTOCOMPLETE' => 'Anular autocompletado',
  'LBL_REPORT_ALLOW_BOOKMARKS' => 'Activar gestión de bookmarks',
		
  'LBL_REPORT_FIELD_REFERENCES' => 'Referencias de campo',
  'LBL_REPORT_FILTER_REFERENCES' => 'Referencias de filtros',
  'LBL_REPORT_CHART_REFERENCES' => 'Referencias de gráficos',

  'LBL_REPORT_FILTERS_LAYOUT' => 'Disposición de los Filtros',
  'LBL_REPORT_FILTERS_LAYOUT_CONFIG' => 'Configuración de la tabla',
  'LBL_REPORT_FILTERS_LAYOUT_COLUMNS' => 'Columnas',
  'LBL_REPORT_FILTERS_LAYOUT_ROWS' => 'Filas',
  'LBL_REPORT_FILTERS_LAYOUT_FILTERS'=>'Filtros',
  'LBL_REPORT_FILTERS_LAYOUT_LAYOUT'=>'Tabla',
  'LBL_REPORT_ADVANCED_SEARCH' => 'Búsqueda Avanzada',
  'LBL_REPORT_BASIC_SEARCH' => 'Búsqueda Básica',
  'LBL_REPORT_FILTERS_LAYOUT_ADD_ROW' => 'Añadir Fila',
  'LBL_REPORT_FILTERS_LAYOUT_DELETE_ROW' => 'Eliminar Fila',
  'LBL_REPORT_FILTERS_LAYOUT_CLEAR' => 'Eliminar todo',
  'LBL_REPORT_FILTERS_DELETE_ALERT' => '¿Quiere eliminar los elementos?',
		
  'LBL_REPORT_FILTERING_DATA_SOURCE' => 'Origen de Datos',
  'LBL_REPORT_FILTERING_DATA_SOURCE_PARAMETER' => 'Parámetro URL',
  'LBL_REPORT_FILTERING_DATA_SOURCE_FILTER' => 'Filtro de Enlace',
		
  'LBL_REPORT_BROADCAST_TITLE' => 'Oyentes',
  'LBL_REPORT_BROADCAST_FILTER' => 'Filtro',
  'LBL_REPORT_BROADCAST_REFERENCE' => 'Referencia',
  'LBL_REPORT_BROADCAST_LISTENER' => '¿Es Oyente?',

  'LBL_REPORT_VISIBILITY_PROPERTIES' => 'Propiedades de Visibilidad',
  'LBL_REPORT_ROLES' => 'Roles',
  'LBL_REPORT_FIELDS_VALUES' => 'Valores de Campos',
  'LBL_REPORT_PROPERTY_NAME' => 'Nombre',
  'LBL_REPORT_PROPERTY_CATEGORY' => 'Categoría',
  'LBL_REPORT_PROPERTY_VALUE' => 'Valor',
  'LBL_REPORT_ADD_VISIBILITY_PROPERTY' => 'Añadir Propiedades de Visibilidad',
	
  'LBL_REPORTS_DUPLICATED_REFERENCES' => 'Advertencia: Hay Referencias Duplicadas',	

  'LBL_REPORT_VISUALIZATION' => 'Visualización',
  'LBL_REPORT_ACLS' => 'ACLs',
		
  'LBL_REPORT_MAP_CONFIG' => 'Configuración del Mapa',
  'LBL_REPORT_MAP_DEFAULT_MATCH' => 'Valor de Comparación',
  'LBL_REPORT_MAP_DISPLAY_VAL' => 'Valores de Presentación',
  'LBL_REPORT_MAP_DEFAULT_BG' => 'Color de Fondo',
		
  'LBL_REPORT_DRAFT' => 'Borrador',
  'LBL_REPORT_CREATE_DRAFT' => 'Crear versión borrador',
  'LBL_REPORT_SWITCH_TO_DRAFT' => 'Cambiar a versión borrador',
  'LBL_REPORT_SWITCH_TO_MAIN' => 'Cambiar a versión principal',

  'LBL_REPORT_MAP_UNKNOW_K_VALS' => 'Claves y valores desconocidos',
  'LBL_REPORT_MAP_TOTAL_UNKNOW_K' => 'Claves desconocidas',
		
  'LBL_REPORT_TARGET_VALUES' => 'Target values',
  'LBL_REPORT_TARGET' => 'Target',

  'LBL_REPORT_CHART_LAYOUT_COLUMS' => 'Columnas',
  'LBL_REPORT_CHART_LAYOUT_CONFIG' => 'Disposicón de gráficos'
);

?>