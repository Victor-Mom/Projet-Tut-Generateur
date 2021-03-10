window.addEventListener('keydown', (event) => {
    if (event.key === 't') {
        let element;
        element = document.createElement('a');
        element.setAttribute('href', 'Vues/resultat.php');
        element.setAttribute('download', 'monpanorama.html');
        element.click();
        console.log("j'ai recu un t");
    }
    else {
        console.log("j'ai recu autre chose");
    }
});