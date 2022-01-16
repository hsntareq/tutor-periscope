/**
 * Ajax request for global use
 *
 * @param {*} formData | form data for post request
 * @returns json response on success or false
 */
export default async function ajaxRequest(formData) {
    const post = await fetch(tp_data.url, {
        method: 'POST',
        body: formData,
    });
    if (post.ok) {
        return await post.json();
    } else {
        return false;
    }
}