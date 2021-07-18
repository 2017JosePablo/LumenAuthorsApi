<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * Return authors list
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index()
	{
		return $this->successResponse(Author::all());
	}

	/**
	 * Create an instance of Author
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
			'gender' => 'required|in:male,female',
			'country' => 'required|max:255',
		]);
		$author = Author::create($request->all());
		return $this->successResponse($author, Response::HTTP_CREATED);
	}

	/**
	 * Return an specific Author
	 * @param $author
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($author)
	{
		return $this->successResponse(Author::findOrFail($author));
	}

	/**
	 * Update the information of an existing Author
	 * @param Request $request
	 * @param $author
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function update(Request $request, $author)
	{
		$this->validate($request, [
			'name' => 'max:255',
			'gender' => 'in:male,female',
			'country' => 'max:255',
		]);
		$author = Author::findOrFail($author);
		$author->fill($request->all());
		if($author->isClean()){
			return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
		}
		$author->save();
		return $this->successResponse($author);
	}

	/**
	 * Remove on existing Author
	 * @param $author
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy($author){
		$author = Author::findOrFail($author);
		$author->delete();
		return $this->successResponse($author);
	}
}
