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
        const lista = document.getElementById('pokemon');
        const pokemons = await this.getByGen(gen);
        lista.innerHTML = '';
        for(const species of pokemons.pokemon_species){
            const url = species.url.replace("-species", "");
            const pokemon = await this.getByUrl(url);
            lista.innerHTML += `
                <li><img src = '${pokemon.sprites.front_default}'></li>
                <br>
            `
        }
    }

    static async showPokemon(){
        const inputQuery = document.getElementById('queryPokemon');
        const div = document.getElementById('pokemon');
        const pokemon = await this.getByUrl(`https://pokeapi.co/api/v2/pokemon/${inputQuery.value}`);
        div.innerHTML = `
        
            <img src=${pokemon.sprites.front_default}>
            <br>
            <button type"button" onclik="Pokemon.addTime()">Adicionar Pokemon ao time</button>

        `
    }

    static async addTime(){
        document.innerHTML +=  `
        
            <?php
            
                

            ?>

        `
    }

}