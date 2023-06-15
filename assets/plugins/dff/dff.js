var room = 1;

function education_fields() {

    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room);
    var rdiv = 'removeclass' + room;
    html = '<div class="row border m-l-5 m-r-5 m-b-25 p-t-20 p-l-10 p-r-10 m-t-20">';
        html += '<div class="col-md-4">';
            html += '<div class="form-group">';
                html += '<label>DCI/Substance active <span class="text-danger">*</span></label>';
                html += '<select class="select2 form-control form-control @error("dci_produit_' + room + '") is-invalid @enderror" id="dci_produit_' + room + '" name="dci_produit[]" autofocus style="width: 100%; height:36px;" required>';
                html += '</select>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2">';
            html += '<div class="form-group">';
                html += '<label>Dosage <span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control @error("dosage_produit_' + room + '") is-invalid @enderror" id="dosage_produit_' + room + '" name="dosage_produit[]" value="" autocomplete="dosage_produit_' + room + '" autofocus required>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2">';
            html += '<div class="form-group">';
                html += '<label>Unité mesure <span class="text-danger">*</span></label>';
                html += '<select class="select2 form-control custom-select form-control @error("unite_mesure_produit_' + room + '") is-invalid @enderror" id="unite_mesure_produit_' + room + '" name="unite_mesure_produit[]" autofocus style="width: 100%; height:36px;" required>';
                html += '</select>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-4">';
            html += '<div class="form-group">';
                html += '<label>Forme <span class="text-danger">*</span></label>';
                html += '<div class="input-group">';
                    html += '<select class="select2 form-control custom-select form-control @error("forme_produit_' + room + '") is-invalid @enderror" id="forme_produit_' + room + '" name="forme_produit[]" autofocus style="height:36px;" required>';
                    html += '</select>';
                    html += '<div class="input-group-append">';
                        html += '<button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i> </button>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
    html += '</div>';

    divtest.innerHTML = html;

    objTo.appendChild(divtest);
    var $options = $('#dci_produit > option').clone();
    $('#dci_produit_'+room+'').append($options);
    var $options = $('#unite_mesure_produit > option').clone();
    $('#unite_mesure_produit_'+room+'').append($options);
    var $options = $('#forme_produit > option').clone();
    $('#forme_produit_'+room+'').append($options);
}

function remove_education_fields(rid) {
    $('.removeclass' + rid).remove();
}

var room_mod = 1;

function education_fields_mod() {

    room_mod++;
    var objTo = document.getElementById('education_fields_mod')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room_mod);
    var rdiv = 'removeclass' + room_mod;
    html = '<div class="row border m-l-5 m-r-5 m-b-25 p-t-20 p-l-10 p-r-10 m-t-20">';
        html += '<div class="col-md-4">';
            html += '<div class="form-group">';
                html += '<label>DCI/Substance active <span class="text-danger">*</span></label>';
                html += '<select class="select2 form-control form-control @error("dci_produit_mod_' + room_mod + '") is-invalid @enderror" id="dci_produit_mod_' + room_mod + '" name="dci_produit_mod[]" autofocus style="width: 100%; height:36px;" required>';
                html += '</select>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2">';
            html += '<div class="form-group">';
                html += '<label>Dosage <span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control @error("dosage_produit_mod_' + room_mod + '") is-invalid @enderror" id="dosage_produit_mod_' + room_mod + '" name="dosage_produit_mod[]" value="" autocomplete="dosage_produit_mod_' + room_mod + '" autofocus required>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-2">';
            html += '<div class="form-group">';
                html += '<label>Unité mesure <span class="text-danger">*</span></label>';
                html += '<select class="select2 form-control custom-select form-control @error("unite_mesure_produit_mod_' + room_mod + '") is-invalid @enderror" id="unite_mesure_produit_mod_' + room_mod + '" name="unite_mesure_produit_mod[]" autofocus style="width: 100%; height:36px;" required>';
                html += '</select>';
            html += '</div>';
        html += '</div>';
        html += '<div class="col-md-4">';
            html += '<div class="form-group">';
                html += '<label>Forme <span class="text-danger">*</span></label>';
                html += '<div class="input-group">';
                    html += '<select class="select2 form-control custom-select form-control @error("forme_produit_mod_' + room_mod + '") is-invalid @enderror" id="forme_produit_mod_' + room_mod + '" name="forme_produit_mod[]" autofocus style="height:36px;" required>';
                    html += '</select>';
                    html += '<div class="input-group-append">';
                        html += '<button class="btn btn-danger" type="button" onclick="remove_education_fields_mod(' + room_mod + ');"> <i class="fa fa-minus"></i> </button>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
    html += '</div>';

    divtest.innerHTML = html;

    objTo.appendChild(divtest);
    var $options = $('#dci_produit_mod > option').clone();
    $('#dci_produit_mod_'+room_mod+'').append($options);
    var $options = $('#unite_mesure_produit_mod > option').clone();
    $('#unite_mesure_produit_mod_'+room_mod+'').append($options);
    var $options = $('#forme_produit_mod > option').clone();
    $('#forme_produit_mod_'+room_mod+'').append($options);
}

function remove_education_fields_mod(rid) {
    $('.removeclass' + rid).remove();
}