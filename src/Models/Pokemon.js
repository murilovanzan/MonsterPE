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

}


