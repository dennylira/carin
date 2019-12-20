function openNav() {
    document.getElementById("mySidenav").style.width = "50%";
    // document.getElementById("flipkart-navbar").style.width = "50%";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
}

function toggleResetPswd(e){
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle() // display:block or none
    $('#logreg-forms .form-reset').toggle() // display:block or none
}

function toggleSignUp(e){
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle(); // display:block or none
    $('#logreg-forms .form-signup').toggle(); // display:block or none
}

$(()=>{
    // Login Register Form
    $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
    $('#logreg-forms #cancel_reset').click(toggleResetPswd);
    $('#logreg-forms #btn-signup').click(toggleSignUp);
    $('#logreg-forms #cancel_signup').click(toggleSignUp);
})

  jQuery(document).ready(function($) {
 
        $('#myCarousel').carousel({
                interval: 5000
        });
 
        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click(function () {
        var id_selector = $(this).attr("id");
        try {
            var id = /-(\d+)$/.exec(id_selector)[1];
            console.log(id_selector, id);
            jQuery('#myCarousel').carousel(parseInt(id));
        } catch (e) {
            console.log('Regex failed!', e);
        }
    });
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
                 var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-'+id).html());
        });
});

/* Máscara telefone */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

/* CEP AUTOMÁTICO */

function limpa_formulário_cep() {
		//Limpa valores do formulário de cep.
		document.getElementById('logradouro').value=("");
		document.getElementById('bairro').value=("");
		document.getElementById('cidade').value=("");
		document.getElementById('uf').value=("");
}

function meu_callback(conteudo) {
	if (!("erro" in conteudo)) {
		//Atualiza os campos com os valores.
		document.getElementById('logradouro').value=(conteudo.logradouro);
		document.getElementById('bairro').value=(conteudo.bairro);
		document.getElementById('cidade').value=(conteudo.localidade);
		document.getElementById('uf').value=(conteudo.uf);
	} //end if.
	else {
		//CEP não Encontrado.
		limpa_formulário_cep();
		alert("CEP não encontrado.");
	}
}
	
function pesquisacep(valor) {

	//Nova variável "cep" somente com dígitos.
	var cep = valor.replace(/\D/g, '');

	//Verifica se campo cep possui valor informado.
	if (cep != "") {

		//Expressão regular para validar o CEP.
		var validacep = /^[0-9]{8}$/;

		//Valida o formato do CEP.
		if(validacep.test(cep)) {

			//Preenche os campos com "..." enquanto consulta webservice.
			document.getElementById('logradouro').value="...";
			document.getElementById('bairro').value="...";
			document.getElementById('cidade').value="...";
			document.getElementById('uf').value="...";

			//Cria um elemento javascript.
			var script = document.createElement('script');

			//Sincroniza com o callback.
			script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

			//Insere script no documento e carrega o conteúdo.
			document.body.appendChild(script);

		} //end if.
		else {
			//cep é inválido.
			limpa_formulário_cep();
			alert("Formato de CEP inválido.");
		}
	} //end if.
	else {
		//cep sem valor, limpa formulário.
		limpa_formulário_cep();
	}
};

/* VALIDADOR E MÁSCARA CNPJ */

$(document).ready(function(){	
		$("#cnpj").mask("99.999.999/9999-99");
	});
	
function validarCNPJ(cnpj) {
 
    cnpj = cnpj.replace(/[^\d]+/g,'');
 
    if(cnpj == '') return false;
     
    if (cnpj.length != 14)
        return false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false; 
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          return false;
           
    return true;
    
}

/* CONTADOR CARACTERES */

$(document).on("input", "#descricao", function() {
        var limite = 851;
        var informativo = "caracteres digitados.";
        var caracteresDigitados = $(this).val().length;
        var caracteresRestantes = limite - caracteresDigitados;

        if (caracteresRestantes <= 0) {
            var descricao = $("textarea[name=descricao]").val();
            $("textarea[name=descricao]").val(descricao.substr(0, limite));
            $(".caracteres").text("0 " + informativo);
        } else {
            $(".caracteres").text(caracteresDigitados + " " + informativo);
        }
    });
	
$(document).on("input", "#comentario", function() {
        var limite = 851;
        var informativo = "caracteres digitados.";
        var caracteresDigitados = $(this).val().length;
        var caracteresRestantes = limite - caracteresDigitados;

        if (caracteresRestantes <= 0) {
            var comentario = $("textarea[name=comentario]").val();
            $("textarea[name=comentario]").val(comentario.substr(0, limite));
            $(".caracteres").text("0 " + informativo);
        } else {
            $(".caracteres").text(caracteresDigitados + " " + informativo);
        }
    });
	
$('#myNavTabs a').click(function (evt) {
  evt.preventDefault();
  $(this).tab('show');
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  //new tab
  console.log(e.target);
  
  //previous tab
  console.log(e.relatedTarget);
})