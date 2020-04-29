/* http://keith-wood.name/calendars.html
   Brazilian Portuguese localisation for calendars datepicker for jQuery.
   Written by Leonildo Costa Silva (leocsilva@gmail.com). */
(function($) {
	'use strict';
	$.calendarsPicker.regionalOptions['pt-BR'] = {
		renderer: $.calendarsPicker.defaultRenderer,
		monthNames: ['Janeiro','Fevreiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		prevText: '&laquo; Anterior',
		prevStatus: 'Mostra o mês anterior',
		prevJumpText: '&lt;&lt;',
		prevJumpStatus: 'Mostra o ano anterior',
		nextText: 'Próximo &raquo;',
		nextStatus: 'Mostra o próximo mês',
		nextJumpText: '&gt;&gt;',
		nextJumpStatus: 'Mostra o próximo ano',
		currentText: 'Atual',
		currentStatus: 'Mostra o mês atual',
		todayText: 'Hoje',
		todayStatus: 'Vai para hoje',
		clearText: 'Limpar',
		clearStatus: 'Limpar data',
		closeText: 'Fechar',
		closeStatus: 'Fechar o calendário',
		yearStatus: 'Selecionar ano',
		monthStatus: 'Selecionar mês',
		weekText: 's',
		weekStatus: 'Semana do ano',
		dayStatus: 'DD, d \'de\' M \'de\' yyyy',
		defaultStatus: 'Selecione um dia',
		isRTL: false
	};
	$.calendarsPicker.setDefaults($.calendarsPicker.regionalOptions['pt-BR']);
})(jQuery);
