<?php
require 'vendor/autolad.php'; // Carrega a biblioteca mPDF

// Dados de conexão com o banco de dados 
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

// Consulta SQL para buscar informações dos livros
$query = "SELECT titulo, autor, ano_publicado, resumo FROM livros";
$stmt = $pdo->prepare(query: $query);
$stmt->execute();

// Recupera os dados do livro
$livros = $stmt-> fetchALL(PDO:: FETCH_ASSOC);

// Cria uma instância do mPDF
$mpdf = new \Mpdf\Mpdf();

// Configura o conteúdo do PDF
$html = '<h1>Biblioteca - Lista de livros<h1>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" width="100%">';
$html .= '<tr>
                <th>título</th>
                <th>autor</th>
                <th>ano de publicação</th>
                <th>resumo</th>
            </tr>';

// Popula o HTML com os dados dos livros
foreach ($livros as $livro) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars(string: $livro['titulo']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['autor']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['ano_publicacao']) . '</td>';
    $html .= '<td>' . htmlspecialchars(string: $livro['resumo']) . '</td>';
    $html .= '</tr>';
}

// Escreva o conteúdo HTML no PDF
$mpdf->writeHTML(html: $html);

// Gera o PDF e força o dowload
$mpdf->Output(name: 'lista_de_livros.pdf', dest: \Mpdf\Output\Destination::DOWLOAD);

{
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}catch (\Mpdf\MpdfExcepition $e) {
    echo "Erro ao gerar o PDF: " . $e-> gerMessage(); 
}