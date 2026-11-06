class Pokeapi{

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
        const pokemons = await this.getByUrl(`https://pokeapi.co/api/v2/generation/generation-${gen}`);
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
    
    static async showCard() {
        let input = document.getElementById('input-busca').value.toLowerCase().trim();
        let telaResultado = document.getElementById('resultado-pesquisa');
        
        if (input === "") return;
        
        telaResultado.innerHTML = "<p style='color: yellow;'>Buscando...</p>";
        
        let pokemon = null;
        try{
            pokemon = await this.getByUrl(`https://pokeapi.co/api/v2/pokemon/${input}`);
        } catch (erro){
            console.log(erro);
            return;
        }
        let tiposFormatados = "";
        pokemon.types.forEach(tipo => {
            tipo.type.name = tiposTraduzidos[tipo.type.name] || tipo.type.name;
            tiposFormatados += tipo.type.name + " | ";
        });

        tiposFormatados = tiposFormatados.replace(/ \| \s*$/, "");
        pokemon.tiposFormatados = tiposFormatados;

            telaResultado.innerHTML = `
                <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                    <div class="cartao-fundo"></div>
                    <img src="${pokemon.sprites.front_default}">
                    <h3 style="margin: 5px 0;">Nº ${pokemon.id} - ${pokemon.name}</h3>
                    <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                    <button onclick="adicionarAoTime(${pokemon})" class="btn-adicionar">Adicionar ao Time</button>
                </div>
            `;
    }
}