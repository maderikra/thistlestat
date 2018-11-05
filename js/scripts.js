var groupcolors = {
    "Private Nonprofit": {
        color: "#28794C"
    },
    "Public 2 Year": {
        color: "#AA7539"
    },
    "Public 4 Year": {
        color: "#AA5039"
    },
    "Public Doctoral": {
        color: "#27556C"
    },
    "Other": {
        color: "#ccc"
    },
    "#N/A": {
        color: "#ccc"
    },
};



var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : encodeURIComponent(sParameterName[1]);
        }
    }
};

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function LightenDarkenColor(col, amt) {

    var usePound = false;

    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }

    var num = parseInt(col, 16);

    var r = (num >> 16) + amt;

    if (r > 255) r = 255;
    else if (r < 0) r = 0;

    var b = ((num >> 8) & 0x00FF) + amt;

    if (b > 255) b = 255;
    else if (b < 0) b = 0;

    var g = (num & 0x0000FF) + amt;

    if (g > 255) g = 255;
    else if (g < 0) g = 0;

    return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);

}



function reload() {
    //gett current benchmarks
    var ohhibenchmark = $('[name^="benchmark"]');
    var benchstr = "";
    for (i = 0; i < ohhibenchmark.length; i++) {
        benchstr += "&benchmark" + (i + 1) + "=" + ohhibenchmark[i]['value'];
    }
    //get current date fmt
    var datefmt = $('[name="range"]:checked').val();
    var inst = $('[name="inst"]').val();
    var sdate = $('#startdate').val();
    var edate = $('#enddate').val();

    window.location.href = window.location.pathname + "?inst=" + inst + "&product=" + getUrlParameter('product') + "&range=" + datefmt + "&startdate=" + sdate + "&enddate=" + edate + benchstr;

}


function reloadpack() {
    //gett current benchmarks
    //get current date fmt
    var datefmt = $('[name="range"]:checked').val();
    var sdate = $('#startdate').val();
    var edate = $('#enddate').val();

    window.location.href = window.location.pathname + "?product=" + getUrlParameter('product') + "&range=" + datefmt + "&startdate=" + sdate + "&enddate=" + edate;

}


function loadproduct(prodtype, prodname) {
    //get current date fmt
    var datefmt = $('[name="range"]:checked').val();
    var inst = $('[name="inst"]').val();
    var sdate = $('#startdate').val();
    var edate = $('#enddate').val();

    //get current benchmarks
    var ohhibenchmark = $('[name^="benchmark"]');
    var benchstr = "";
    for (i = 0; i < ohhibenchmark.length; i++) {
        benchstr += "&benchmark" + (i + 1) + "=" + ohhibenchmark[i]['value'];
    }
    window.location.href = prodtype + ".php?inst=" + getUrlParameter("inst") + "&product=" + prodname + "&range=" + datefmt + "&startdate=" + sdate + "&enddate=" + edate + benchstr;
}