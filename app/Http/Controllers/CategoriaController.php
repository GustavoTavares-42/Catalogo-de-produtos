<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CategoriaModel;
use Validator;

class CategoriaController  extends Controller
{
    public function buscarCategorias()
    {
        $categorias = CategoriaModel::all();

        if($categorias)
        {
            return response()->json($categorias);
        }
        else
        {
            return response()->json(['erro' => 'Categorias não encontradas'], 404);
        }
    }

    public function buscarCategoria($id)
    {
        $categoria = CategoriaModel::find($id);

        if($categoria)
        {
            return response()->json($categoria);
        }
        else
        {
            return response()->json(['erro' => 'Categoria não encontrada'], 404);
        }
    }

    public function cadastrarCategoria(Request $request)
    {
        $dados = $request->only(['nome']);

        $regras = ['nome' => 'required|string|unique:categorias,nome'];
        
        $erros = [
            'required' => 'O campo :attribute é obrigatório',
            'string'   => 'O campo :attribute deve ser string',
            'unique'   =>  'Já existe una categoria com esse nome'
        ];

        $valida = Validator::make($dados, $regras, $erros);

        if($valida->fails())
        {
            return response()->json(['erro' => $valida->erros()], 400);
        }
        $categoria = CategoriaModel::create($dados);
        
        return response()->json($categoria, 201);
    }

    public function atualizarCategoria(Request $request, $id)
    {
        $categoria = CategoriaModel::find($id);

        if(!$categoria)
        {
            return response()->json(['erro' => 'Categoria não encontrada'] , 404);
        }

        $dados = $request->only(['nome']);

        $regras = [
            'nome' => [
                'required',
                'string',
                Rule::unique('categorias', 'nome')->ignore($categoria->id)
            ]
        ];

        $erros = [
            'reuired' => 'O campo :attribute é obrigatório',
            'string'  => 'O campo :attribute deve ser string',
            'Unique'  => 'Já existe uma categoria com esse nome'
        ];

        $valida = Validator::make($dados, $regras, $erros);

        if($valida->fails())
        {
            return response()->json(['erro'  => $valida->errors()], 400);
        }

        $categoria->nome = $dados['nome'];

        if(!$categoria->save())
        {
            return response()->json(['erro' => 'Não foi possível atualizar a categoria'], 500);
        }

        return response()->json($categoria, 200);
    }

    public function excluirCategoria($id)
    {
        $categoria = CategoriaModel::find($id);

        if(!$categoria)
        {
            return response()->json(['erro' => 'Categoria não encontrada'], 404);
        }

        if(!$categoria->delete())
        {
            return response()->json(['erro' => 'Não foi possivel excluir a categoria'], 500);
        }

        return response()->json(['msg' => 'Categoria excluída com sucesso!'], 200);
    }
}
