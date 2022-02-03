const bulk_user_import = document.getElementById('bulk_user_import');
if (null !== bulk_user_import) {
    bulk_user_import.onchange = (e) => {
        var files = bulk_user_import.files;
        e.preventDefault();
        console.log(files);
        if (files.length <= 0) {
            return false;
        }
        var fr = new FileReader();
        fr.readAsText(files.item(0));
        fr.onload = function (e) {
            var periscope_bulk_user = e.target.result;
            var formData = new FormData();
            formData.append('action', 'periscope_user_import');
            formData.append(_tutorobject.nonce_key, _tutorobject._tutor_nonce);
            // formData.append('time', time_now());
            formData.append('bulk_user', JSON.stringify(periscope_bulk_user));
            const xhttp = new XMLHttpRequest();
            xhttp.open('POST', _tutorobject.ajaxurl);

            // console.log(formData);
            // return false;
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4) {
                    console.log(JSON.parse(xhttp.response));
                    // modalElement.classList.remove('tutor-is-active');
                    // let historyData = JSON.parse(xhttp.response);
                    // historyData = historyData.data;
                    // tutor_option_history_load(Object.entries(historyData));
                    // delete_history_data();
                    // import_history_data();
                    // setTimeout(function () {
                    //     tutor_toast('Success', 'Data imported successfully!', 'success');
                    //     fileElem.parentNode.parentNode.querySelector('.file-info').innerText = '';
                    //     fileElem.value = '';
                    // }, 200);
                }
            };
        };

        // var fr = new FileReader();

        // fr.onload = function (e) {
        //     // console.log(e);
        //     var result = JSON.parse(e.target.result);
        //     var formatted = JSON.stringify(result, null, 2);
        //     // document.getElementById('result').value = formatted;
        //     // console.log(formatted);
        // }

        // fr.readAsText(files.item(0));
    }
}

jQuery(function () {
    jQuery('.select2').select2({
        placeholder: 'Select an option',
        width: '400px'
    });
})