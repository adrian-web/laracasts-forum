Livewire.on('previousBest', previousId => {

    if (document.getElementById('reply' + previousId)) {
        document.getElementById('reply' + previousId).className = 'my-2';
    }

});