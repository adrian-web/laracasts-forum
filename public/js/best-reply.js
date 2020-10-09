Livewire.on('best', (oldId, newId) => {

    try {
        if (document.getElementById('reply' + oldId)) {
            document.getElementById('reply' + oldId).classList.remove("bg-green-200", "rounded-md", "shadow-nd", "p-2");
        }

    }
    finally {
        if (document.getElementById('reply' + newId)) {
            document.getElementById('reply' + newId).classList.add("bg-green-200", "rounded-md", "shadow-nd", "p-2");
        }
    }

});