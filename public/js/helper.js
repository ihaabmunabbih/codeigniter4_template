function returnConfirmation(url, idTable) {
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',

		beforeSend: function () {
            Swal.showLoading();
		},

		success: function (data) {
			if (data.code == 200) {
				Swal.fire({
                    title: 'Sukses',
                    html: data?.message,
                    icon: "success",
                    timer: 3000,
                    timerProgressBar: true,
                    confirmButtonText: 'Oke!',
                    allowEscapeKey: false,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        if ($.fn.DataTable.isDataTable( '#'+idTable )) {
                            $('#'+idTable).DataTable().ajax.reload();
                        } else {
                            $('#'+idTable).treegrid('reload');
                            window.location = BASEURL + '/managementmodul';
                        }
                    }
                    
                    if ($.fn.DataTable.isDataTable( '#'+idTable )) {
                        $('#'+idTable).DataTable().ajax.reload();
                    } else {
                        $('#'+idTable).treegrid('reload');
                        window.location = BASEURL + '/managementmodul';
                    }
                })
			} else {
				Swal.fire({
                    title: 'Gagal',
                    html: data?.message,
                    icon: "error",
                    confirmButtonText: 'Oke!'
                }).then(() => {
                    if ($.fn.DataTable.isDataTable( '#'+idTable )) {
                        $('#'+idTable).DataTable().ajax.reload();
                    } else {
                        $('#'+idTable).treegrid('reload');
                    }
                });
			}
		},

		error: function () {
			
		},

		complete: function () {
		}
	});
}

function confirmationAction(title, message, idTable, url) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, yakin!'
    }).then((result) => {
        if (result.isConfirmed) {
            returnConfirmation(url, idTable)
        }
    })
}


/* ---------- start of toggle visibility password ------------ */
$('.show-password').mousedown(function () {
    let field = document.getElementById('password');

    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }

    $('.fa-eye').addClass('d-none');
    $('.fa-eye-slash').removeClass('d-none');
});

$('.show-password').mouseup(function () {
    let field = document.getElementById('password');

    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }

    $('.fa-eye').removeClass('d-none');
    $('.fa-eye-slash').addClass('d-none');
});
/* ---------- end of toggle visibility password ------------ */


function getDeviceInfo() {
    var nAgt = navigator.userAgent;
    var nameOffset,verOffset,ix;
    var OSName="Unknown OS";

    if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
    if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
    if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
    if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

    // In Opera, the true version is after "OPR" or after "Version"
    if ((verOffset=nAgt.indexOf("OPR"))!=-1) {
        browserName = "Opera";
        fullVersion = nAgt.substring(verOffset+4);
        if ((verOffset=nAgt.indexOf("Version"))!=-1) 
        fullVersion = nAgt.substring(verOffset+8);
    }
    // In MS Edge, the true version is after "Edg" in userAgent
    else if ((verOffset=nAgt.indexOf("Edg"))!=-1) {
        browserName = "Microsoft Edge";
        fullVersion = nAgt.substring(verOffset+4);
    }
    // In MSIE, the true version is after "MSIE" in userAgent
    else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
        browserName = "Microsoft Internet Explorer";
        fullVersion = nAgt.substring(verOffset+5);
    }
    // In Chrome, the true version is after "Chrome" 
    else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
        browserName = "Chrome";
        fullVersion = nAgt.substring(verOffset+7);
    }
    // In Safari, the true version is after "Safari" or after "Version" 
    else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
        browserName = "Safari";
        fullVersion = nAgt.substring(verOffset+7);
        if ((verOffset=nAgt.indexOf("Version"))!=-1) 
        fullVersion = nAgt.substring(verOffset+8);
    }
    // In Firefox, the true version is after "Firefox" 
    else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
        browserName = "Firefox";
        fullVersion = nAgt.substring(verOffset+8);
    }
    // In most other browsers, "name/version" is at the end of userAgent 
    else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
            (verOffset=nAgt.lastIndexOf('/')) ) 
    {
        browserName = nAgt.substring(nameOffset,verOffset);
        fullVersion = nAgt.substring(verOffset+1);
    }
    // trim the fullVersion string at semicolon/space if present
    if ((ix=fullVersion.indexOf(";"))!=-1)
        fullVersion=fullVersion.substring(0,ix);
    if ((ix=fullVersion.indexOf(" "))!=-1)
        fullVersion=fullVersion.substring(0,ix);

    majorVersion = parseInt(''+fullVersion,10);

    // var ip = await $.getJSON("https://api.ipify.org")
    
    return {
        'browserName' : browserName,
        'fullVersion' : fullVersion,
        'majorVersion' : majorVersion,
        'OSName'  : OSName
    }

}

function getDateOnly(dateParams, separator) {
    const t     = new Date(dateParams);
    const date  = ('0' + t.getDate()).slice(-2);
    const month = ('0' + (t.getMonth() + 1)).slice(-2);
    const year  = t.getFullYear();
    return `${date}${separator}${month}${separator}${year}`;
}

function getKeyByValue(object, value) {
    return Object.keys(object).find(key => object[key] == value);
}