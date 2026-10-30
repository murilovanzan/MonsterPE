class Pokemon{

    static async getByGen(gen){

        try{

            const resposta = await fetch(`https://pokeapi.co/api/v2/generation/generation-${gen}`);

            if(!resposta.ok){
                throw new Error(`Erro na busca dos Pokémon da geração ${gen}!`);
            }

            const dados = await resposta.json();
            return dados;

        }catch(erro){
            console.error("Falha: ", erro);
        }

    }

    static async getByUrl(url){

        try{

            const resposta = await fetch(url);
            if(!resposta.ok){
                throw new Error('Erro ao buscar a url: ', url);
            }

            const dados = await resposta.json();
            return dados;

        }catch(erro){
            console.error("Erro: ", erro);
        }
    }

    static async showGen(gen){
        document.getElementById('opgens').classList.remove('ativo');
        document.getElementById('voltargen').classList.add('ativo');
        const lista = document.getElementById('pokemon');
        const pokemons = await this.getByGen(gen);
            lista.innerHTML = '';
            for(const species of pokemons.pokemon_species){
                const url = species.url.replace("-species", "");
                const pokemon = await this.getByUrl(url);
                let nomeTipo1 = pokemon.types[0].type.name;
                let tiposPokemon = tiposTraduzidos[nomeTipo1] || nomeTipo1; 

                if(pokemon.types.length > 1) {
                    let nomeTipo2 = pokemon.types[1].type.name;
                    tiposPokemon += " / " + (tiposTraduzidos[nomeTipo2] || nomeTipo2);
                }
                lista.innerHTML += `
                    <li class="cartao-pokemon">
                        <div class="cartao-fundo"></div>
                        <img src='${pokemon.sprites.front_default}'>
                        <h3>${pokemon.name}</h3>
                        <h3>#${pokemon.id}</h3>
                    
                        <div class="costas-seguras">
                            <h3>${pokemon.name}</h3>
                            <p>${tiposPokemon}</p>
                        </div>
                    </li>`
            }
    }


    static async getPokemon(){
        const inputQuery = document.getElementById('queryPokemon');
        const div = document.getElementById('pokemon');
        const pokemon = await this.getByUrl(`https://pokeapi.co/api/v2/pokemon/${inputQuery.value}`);
        div.innerHTML = `
        
            <img src=${pokemon.sprites.front_default}>
            <br>
            <button type"button" onclik="Pokemon.addTime()">Adicionar Pokemon ao time</button>

        `
    }
}