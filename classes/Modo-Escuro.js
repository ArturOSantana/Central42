class ModoEscuro {
    constructor() {
        this.estaEscuro = localStorage.getItem('modoEscuro') === 'true';
        this.iniciar();
    }

iniciar() {
        this.aplicarTema();
        if(!document.getElementById('btn-modo-escuro')){
            this.criarBotaoAlternancia();
        }
    }

aplicarTema() {
        if (this.estaEscuro) {
            document.documentElement.classList.add('modo-escuro');
        } else {
            document.documentElement.classList.remove('modo-escuro');
        }   
    }

criarBotaoAlternancia() {
        const botao = document.createElement('button');
        botao.id = 'btn-modo-escuro';
        botao.innerText = this.estaEscuro ? 'Modo Claro' : 'Modo Escuro';
        botao.style.position = 'fixed';
        botao.style.bottom = '20px';
        botao.style.right = '20px';
        botao.style.padding = '10px 15px';
        botao.style.zIndex = '1000';
        botao.onclick = () => this.alternarModo();
        document.body.appendChild(botao);

        const navbar = document.querySelector('.nav .container-fluid');
        if (navbar) {
            navbar.appendChild(botao);
        }   
    }

    
alternarModo() {
        this.estaEscuro = !this.estaEscuro;
        localStorage.setItem('modoEscuro', this.estaEscuro);
        this.aplicarTema();
        const botao = document.getElementById('btn-modo-escuro');
        if (botao) {
            botao.innerText = this.estaEscuro ? 'Modo Claro' : 'Modo Escuro';
        }
    }


ativar() {
        this.estaEscuro = true;
        localStorage.setItem('modoEscuro', 'true');
        this.aplicarTema();
    }

desativar() {
        this.estaEscuro = false;
        localStorage.setItem('modoEscuro', 'false');
        this.aplicarTema();
    }
}

const modoClaro = new ModoClaro();
export default modoClaro;
