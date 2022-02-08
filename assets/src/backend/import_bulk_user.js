const bulkUserImport = document.getElementById('bulk_user_import');

if (null !== bulkUserImport) {
    bulkUserImport.onchange = (e) => {
        console.log('import started');
        var files = bulkUserImport.files;
        e.preventDefault();
        console.log(files);
        if (files.length <= 0) {
            return false;
        }
        var fr = new FileReader();
        fr.readAsText(files.item(0));
        fr.onload = function (e) {
            var bulkUserImport = e.target.result;
            var formData = new FormData();
            formData.append('action', 'periscope_user_import');
            formData.append(_tutorobject.nonce_key, _tutorobject._tutor_nonce);
            // formData.append('time', time_now());
            formData.append('bulk_user', JSON.stringify(csvToObjs(bulkUserImport)));
            const xhttp = new XMLHttpRequest();
            xhttp.open('POST', _tutorobject.ajaxurl);

            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (xhttp.readyState === 4) {
                    console.log(JSON.parse(xhttp.response));
                    tutor_toast('Success', 'Bulk users added successfully!', 'success');
                    location.reload();
                }
            };
        };
    }
}

const csvToObjs = (string) => {
    const lines = string.split(/\r\n|\n/);
    let obj, [headings, ...entries] = lines;
    headings = headings.split(',');
    const objs = [];
    entries.map(entry => {
        obj = entry.split(',');
        objs.push(Object.fromEntries(headings.map((head, i) => [head, obj[i]])));
    })
    return objs;
}