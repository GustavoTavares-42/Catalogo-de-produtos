<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProdutoModel;
use Validator;

class ProdutoController extends Controller
{
    public function buscarProdutos()
    {
        $produtos = ProdutoModel::all();
        if($produtos)
        {
            return response()->json($produtos);
        }
        else
        {
            return response()->json(['erro' => 'Produtos não encontrados'], 404);
        }
    }

    public function buscarProduto($id)
    {
        $produto = ProdutoModel::find($id);

        if($produto)
        {
            return response()->json($produto);
        }
        else
        {
            return response()->json(['erro' => 'Produto não encontrado'], 404);
        }
    }

    public function cadastrarProduto(Request $request)
    {
        $dados = $request->only(['categoria_id', 'codigo', 'nome', 'preco', 'preco_promocional', 'ativo']);

        $regras = [
            'categoria_id' => 'required|exists:categorias,id',
            'codigo' => 'required|string|unique:produtos,codigo',
            'nome' => 'required|string|unique:produtos,nome',
            'preco' => 'required|numeric',
            'preco_promocional' => 'nullable|numeric',
            'ativo' => 'nullable|boolean'
        ];
            
        $erros = [
            'required' => 'O campo :attribute é obrigatório',
            'string'   => 'O campo :attribute deve ser string',
            'unique'   => 'Já existe um produto com esse :attribute',
            'numeric'  => 'O campo :attribute deve ser numérico',
            'boolean'  => 'O campo :attribute deve ser booleano',
            'exists'   => 'A categoria informada não existe'
        ];

        $valida = Validator::make($dados, $regras, $erros);

        if($valida->fails())
        {
            return response()->json(['erro' => $valida->errors()], 400);
        }

        $produto = ProdutoModel::create($dados);
            
        return response()->json($produto, 201);
    }


    public function atualizarProduto(Request $request, $id)
    {
        $produto = ProdutoModel::find($id);

        if (!$produto) {
            return response()->json(['erro' => 'Produto não encontrado'], 404);
        }

        $dados = $request->only(['nome', 'preco', 'categoria_id', 'codigo', 'descricao', 'preco_promocional', 'ativo']);

        $regras = [
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'codigo' => 'string|max:50',
            'descricao' => 'string',
            'preco_promocional' => 'nullable|numeric',
            'ativo' => 'boolean'
        ];

        $erros = [
            'required' => 'O campo :attribute é obrigatório',
            'string' => 'O campo :attribute deve ser uma string',
            'numeric' => 'O campo :attribute deve ser um número',
            'exists' => 'A categoria selecionada não existe',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres',
            'boolean' => 'O campo :attribute deve ser booleano'
        ];

        $valida = Validator::make($dados, $regras, $erros);

        if ($valida->fails()) {
            return response()->json(['erro' => $valida->errors()], 400);
        }

        $produto->fill($dados);

        if (!$produto->save()) {
            return response()->json(['erro' => 'Não foi possível atualizar o produto'], 500);
        }

        return response()->json($produto, 200);
    }


    public function excluirProduto($id)
    {
        $produto = ProdutoModel::find($id);

        if (!$produto) {
            return response()->json(['erro' => 'Produto não encontrado'], 404);
        }

        if (!$produto->delete()) {
            return response()->json(['erro' => 'Não foi possível excluir o produto'], 500);
        }

        return response()->json(['msg' => 'Produto excluído com sucesso!'], 200);
    }

}