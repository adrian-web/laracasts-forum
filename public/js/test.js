new Vue({

    created: function () {
        axios.get('api/user').then(response => {
            console.log(response);
        })
    }

});
