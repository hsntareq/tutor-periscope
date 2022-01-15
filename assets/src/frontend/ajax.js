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