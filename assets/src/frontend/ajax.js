/**
 * Ajax request for global use
 *
 * @param {*} formData | form data for post request
 * @returns json response on success or false
 */
export default async function ajaxRequest(formData) {
    const loader = `<div id="tutor-periscope-loader-wrapper">
        <div class="tutor-periscope-loading">
        </div>
    </div>`;
    document.body.insertAdjacentHTML(
        'beforeend',
        loader
    );
    const post = await fetch(tp_data.url, {
        method: 'POST',
        body: formData,
    });
    document.getElementById('tutor-periscope-loader-wrapper').remove();
    if (post.ok) {
        return await post.json();
    } else {
        return false;
    }
}