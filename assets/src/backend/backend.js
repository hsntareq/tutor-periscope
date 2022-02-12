import html2pdf from 'html2pdf.js';
import "./backend_jquery";
import "./student-attempt";
import "./import_bulk_user";
import "./metabox";
// import "./student_assignment";
jQuery(document).ready(function () {

    this.PrintDiv = () => {
        var divToPrint = document.querySelector('#div-to-print');
        var popupWin = window.open('', '_blank', 'width=800,height=500');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

    this.exportPDF = () => {
        var element  = document.querySelector('#div-to-print');
        var getTitle = document.querySelector('#title');
        var title    = getTitle.getAttribute('data-title');
        var options = {
            margin:       1,
            filename:     `${title}.pdf`,
            image:        { type: 'jpeg', quality: 0.99 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

        if ( null !== element ) {
            html2pdf().set(options).from(element.innerHTML).save();
        }
    }
});