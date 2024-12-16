const getMenuData = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/core_menus/ajax',
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

const iconPickerOpt = {
    cols: 500,
    searchText: 'Buscar...',
    labelHeader: '{0} de {1} Pags.',
    footer: false
};

const options = {
    hintCss: {
        'border': '1px dashed #13981D'
    },
    placeholderCss: {
        'background-color': 'gray'
    },
    opener: {
        as: 'html',
        close: '<i class=\'fas fa-minus\'></i>',
        open: '<i class=\'fas fa-plus\'></i>',
        openerCss: {
            'margin-right': '10px'
        },
        openerClass: 'btn btn-success btn-xs'
    }
};

jQuery(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
        }
    });

    const editor = new MenuEditor('menuEditor', {
        listOptions: options,
        iconPicker: iconPickerOpt,
        labelEdit: 'Edit'
    });

    getMenuData().then(function(data) {
        editor.setData(data.arr);
    });

    editor.setForm($('#formEdit'));
    editor.setUpdateButton($('#btnUpdate'));
      
    $('#btnOut').on('click', function() {
        var str = editor.getString();
        $('#out').text(str);

        $.ajax({
            url: '/core_menus',
            type: 'POST',
            data: {
                menus: str
            },
            dataType: 'json',
            success: function(data) {
                $('.saveMenusBtn').text(' Done ');
                setTimeout(function() {
                    $('.saveMenusBtn').text(' Save ');
                }, 3000);
            }
        });
    });
    $('#btnUpdate').on('click', function() {
        editor.update();
        $('#btnOut').trigger( 'click' );
    });
    $('#btnAdd').on('click', function() {
        editor.add();
    });
});