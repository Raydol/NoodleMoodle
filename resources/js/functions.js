function filtrarRol(esPrimeraVez) {
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

            //Columna para borrar un usuario
            let td10 = document.createElement("td");
            let enlacePapelera = document.createElement("a")
            let iconoPapelera = document.createElement("i")

            td10.className += " text-center"

            enlacePapelera.setAttribute("href", "javascript:void(0)")
            enlacePapelera.className += " text-dark"
            enlacePapelera.setAttribute("style", "text-decoration: none")
            enlacePapelera.setAttribute("onclick", "deleteUser(" + user.Id +")")

            iconoPapelera.className += " fas fa-trash-alt"

            enlacePapelera.append(iconoPapelera)
            td10.append(enlacePapelera)

            tr.append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10);
            tb.appendChild(tr);
        }
    });
}

function addSubjectToModule(cont, id_module) {
 
    var id_subject = document.getElementById(cont).value;
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
            let option = document.getElementById("option"+id_subject+cont);
            select.removeChild(option);
        }

    });

}

function generateCode() {

    $.ajax({
        url: '/NoodleMoodle/public/subject/new/generatecode',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(res) {

        //Primero vacíamos tanto el span como el input del código de activación del formulario
        document.getElementById("generatedCode").innerHTML = "";
        document.getElementById("inputGeneratedCode").innerHTML = "";

        //Asignamos el valor que nos viene del servidor al span y al input
        document.getElementById("generatedCode").innerHTML = res
        document.getElementById("inputGeneratedCode").value = res

    })

}

function deleteUser(id) {
    if(confirm("Desea realmente eliminar este usuario")) {
        let filtro = document.getElementById("rol").value
        let data = [id, filtro]
        $.ajax({
            url: '/NoodleMoodle/public/user/delete',
            method: 'POST',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(res) {
            let tb = document.getElementById("tableBody")
            tb.innerHTML = "";
            var users = JSON.parse(res)

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

                //Columna para borrar un usuario
                let td10 = document.createElement("td");
                let enlacePapelera = document.createElement("a")
                let iconoPapelera = document.createElement("i")

                td10.className += " text-center"

                enlacePapelera.setAttribute("href", "javascript:void(0)")
                enlacePapelera.className += " text-dark btn btn-outline-dark"
                enlacePapelera.setAttribute("style", "text-decoration: none")
                enlacePapelera.setAttribute("onclick", "deleteUser(" + user.Id +")")

                iconoPapelera.className += " fas fa-trash-alt"

                enlacePapelera.append(iconoPapelera)
                td10.append(enlacePapelera)
                
                tr.append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10);
                tb.appendChild(tr);
            }
        })

    }
}

function joinModule(id_module) {
    if(confirm("¿Está seguro de que desea unirse a este módulo?")) {
        location.href = "/NoodleMoodle/public/module/"+ id_module + "/join"; 
    }
}

function leaveModule(id_module) {
    if(confirm("¿Está seguro de que desea abandonar este módulo?")) {
        location.href = "/NoodleMoodle/public/module/"+ id_module + "/leave";
    }
}

function deleteModule(id_module) {
    if(confirm("¿Desea eliminar realmente este módulo?")) {
        location.href = "/NoodleMoodle/public/module/" + id_module +"/delete"
    }
}

function deleteSubject(id) {
    if (confirm("¿Desea eliminar realmente esta asignatura?")) {
        var data = [id]

        $.ajax({
            url: '/NoodleMoodle/public/subject/delete',
            method: 'POST',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(res) {
            let tbody = document.getElementById('tbody')
            tbody.innerHTML = "";

            var subjects = JSON.parse(res)

            for (let subject of subjects) {
                var tr = document.createElement("tr");
                let td1 = document.createElement("td");
                td1.innerHTML = subject.NombreAsignatura;
                let td2 = document.createElement("td");
                td2.innerHTML = subject.AmountOfModules;
                let td3 = document.createElement("td");
                td3.innerHTML = subject.AmountOfStudents;

                //Creamos el td del enlace de borrado
                let td4 = document.createElement("td");
                let enlacePapelera = document.createElement("a")
                let iconoPapelera = document.createElement("i")

                td4.className += " text-center"

                enlacePapelera.setAttribute("href", "javascript:void(0)")
                enlacePapelera.className += " text-dark btn btn-outline-dark"
                enlacePapelera.setAttribute("style", "text-decoration: none")
                enlacePapelera.setAttribute("onclick", "deleteSubject(" + subject.Id +")")

                iconoPapelera.className += " fas fa-trash-alt"

                enlacePapelera.append(iconoPapelera)
                td4.append(enlacePapelera)

                tr.append(td1, td2, td3, td4)
                tbody.appendChild(tr);
            }
        })

    }
}



















/*function filterSubject() {
    let value = document.getElementById('filter_subject').value

    $.ajax({
        url: '/NoodleMoodle/public/subjectslist',
        method: 'POST',
        data: JSON.stringify(value),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(res) {

        console.log(res)

        var tbody = document.getElementById('tbody')
        tbody.innerHTML = ""

        let subjects = JSON.parse(res)

        for(let subject of subjects) {
            var tr = document.createElement('tr')
            var td1 = document.createElement('td')
            td1.innerHTML = subject.NombreAsignatura
            var td2 = document.createElement('td')
            td2.innerHTML = subject.AmountOfModules
            var td3 = document.createElement('td')
            td3.innerHTML = subject.AmountOfStudents

            tr.append(td1, td2, td3);
            tbody.appendChild(tr);
        }


    })

}*/