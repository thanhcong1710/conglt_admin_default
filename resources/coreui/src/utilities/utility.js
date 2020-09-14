function processAuthen(error) {
    // console.log(error.response.data);
    // console.log(error.response.status);
    // console.log(error.response.headers);
    try {
        if (error.response.status == 401) {
            window.location.href = '/#/login';
        }
    } catch (err) {}

}

export default {
    processAuthen,
}
