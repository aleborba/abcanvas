<?php
	require_once 'inc/conexao.php';
	
	
	if (!$local) $local = $_GET['local'];
	if (!$usuario) $usuario = $_SESSION['usuario'];
	
	if ($_GET['local'] && $_GET['local']!='estrutura' && $_GET['local']!='receitas') $adiciona = 'margin-top: -15px;';
?>

   <style>
    #ordenando<?php echo $local; ?> ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
    #ordenando<?php echo $local; ?> li { margin: 5px; padding: 5px; width: 180px; float:left;  }
    </style>
    
        
<ul id="ordenando<?php echo $local; ?>" style=" <?php echo $adiciona; ?>">	 
<?php echo $adiciona; ?>

<?php
		
	$processo = mysql_query("SELECT id, texto, cor, data FROM postagens WHERE usuario='$usuario' AND local='$local' ORDER BY ordem");
	if (mysql_num_rows($processo)) {
		while ($dados = mysql_fetch_assoc($processo)) {
		$id = $dados['id'];
		$texto = $dados['texto'];
		$cor = $dados['cor'];
		$texto = $dados['texto'];
		$data = $dados['data'];
?>
	<li id="<?php echo $id; ?>" onMouseOver="$('.exclui<?php echo $id; ?>').show();" onMouseOut="$('.exclui<?php echo $id; ?>').hide();" style="background:<?php echo $cor; ?>;"><?php echo $texto; ?> <span style="display:none; background:#C00; padding:1px 4px;" class="exclui<?php echo $id; ?>"><a href="Excluir.php?id=<?php echo $id; ?>&local=<?php echo $local; ?>" target="#AcoesOcultas" onClick="return Aviso(this, 'Tem certeza que deseja excluir:\n\n <?php echo $texto; ?>'); return Link(this);" style="color:#FFF; text-decoration:none; font-size:10px; font-weight:bold;">Excluir</a></span></li>
<?php
		}
	}
?>
</ul>


    <script>
    $(function() {
        $( "#ordenando<?php echo $local; ?>" ).sortable({
            revert: true,
		    update: function(event, ui) {
            var newOrder = $(this).sortable('toArray').toString();
		    $.get('Ordenar.php', {local:'<?php echo $local; ?>', NovaOrdem:newOrder});
        }
        });
        $( "#draggable" ).draggable({
            connectToSortable: "#ordenando<?php echo $local; ?>",
            helper: "clone",
            revert: "invalid"
        });
        $( "ul, li" ).disableSelection();
    });
    </script>