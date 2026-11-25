let timeOponente = [];

async function gerarTimeAutomatico(){

    for(let i=0;i<6;i++){
        timeOponente.push(await getByUrl(`https://pokeapi.co/api/v2/pokemon/${i+1}`));
    }

    return timeOponente;
}