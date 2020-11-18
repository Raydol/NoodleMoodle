function filtrarRol() {
    let value = document.getElementById('rol').value;

    $.ajax({
        url: '/NoodleMoodle/public/userslist',
        method: 'POST',
        data: JSON.stringify(value),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(res) {
        let tb = document.getElementById("tableBody")
        tb.innerHTML = "";
        var users = JSON.parse(res);
        for(let user of users) {
            var tr = document.createElement("tr");
            let td1 = document.createElement("td");
            td1.innerHTML = user.Nombre;
            let td2 = document.createElement("td");
            td2.innerHTML = user.Apellidos;
            let td3 = document.createElement("td");
            td3.innerHTML = user.Email;
            let td4 = document.createElement("td");
            td4.innerHTML = user.Telefono;
            let td5 = document.createElement("td");
            td5.innerHTML = user.Ciudad;
            let td6 = document.createElement("td");
            td6.innerHTML = user.ComunidadAutonoma;
            let td7 = document.createElement("td");
            td7.innerHTML = user.RolName;
            let td8 = document.createElement("td");
            td8.innerHTML = user.FechaPrimerAcceso;
            let td9 = document.createElement("td");
            td9.innerHTML = user.FechaUltimoAcceso;
            let td10 = document.createElement("td");
            td10.innerHTML = "Acciones";

            tr.append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10);
            tb.appendChild(tr);
        }
    });
}

function addSubjectToModule(cont, id_module) {
 
    let id_subject = document.getElementById(cont).value;
    let data = [id_subject, id_module];

    $.ajax({
        url: '/NoodleMoodle/public/moduleslist',
        method: 'POST',
        data: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(res) {

        if (res) {
            //Recupero la asignatura
            let subject = JSON.parse(res)

            //Selecciono el td en el que voy a hacer un append de la nueva asignatura
            let td = document.getElementById("td"+cont)

            //Creo el span de la nueva asignatura
            let span = document.createElement("span")
            span.innerHTML = ' "' +subject.NombreAsignatura + '"'

            //Uno el span al final del td
            td.append(span)

            //Borro la asignatura del select
            let select = document.getElementById(cont);
            let option = document.getElementById("option"+id_subject);
            select.removeChild(option);
        }

    });

}