$.fn.select2.amd.define('select2/i18n/it',[],function () {
    return {
        errorLoading: function () {
            return 'Impossibile caricare il risultato.';
        },
        inputTooLong: function (args) {
            var overChars = args.input.length - args.maximum;
            var message = 'Rimuovi il simbolo ' + overChars + ' simbol';
            if (overChars >= 2) {
                message += 'i';
            } else {
                message += 'o';
            }
            return message;
        },
        inputTooShort: function (args) {
            var message = 'Digita almeno ' + args.minimum + ' caratteri';

            return message;
        },
        loadingMore: function () {
            return 'Caricamento di altre risorse...';
        },
        maximumSelected: function (args) {
            var message = 'Puoi scegliere ' + args.maximum + ' element';

            if (args.maximum >= 2) {
                message += 'i';
            } else {
                message += 'o';
            }

            return message;
        },
        noResults: function () {
          return 'Nessun risultato trovato';
        },
        searching: function () {
          return 'Ricerca…';
        }
    };
});