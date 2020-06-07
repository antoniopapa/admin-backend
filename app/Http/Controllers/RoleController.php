<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * @OA\Get(path="/roles",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="200",
     *     description="Role Collection",
     *   )
     * )
     */
    public function index()
    {
        \Gate::authorize('view', 'roles');

        return RoleResource::collection(Role::all());
    }

    /**
     * @OA\Post(
     *   path="/roles",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="201",
     *     description="Role Create",
     *   )
     * )
     */
    public function store(Request $request)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::create($request->only('name'));

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return response(new RoleResource($role), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(path="/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function show($id)
    {
        \Gate::authorize('view', 'roles');

        return new RoleResource(Role::find($id));
    }

    /**
     * @OA\Put(
     *   path="/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="202",
     *     description="Role Update",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::find($id);

        $role->update($request->only('name'));

        \DB::table('role_permission')->where('role_id', $role->id)->delete();

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return response(new RoleResource($role), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(path="/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="204",
     *     description="Role Delete",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function destroy($id)
    {
        \Gate::authorize('edit', 'roles');

        \DB::table('role_permission')->where('role_id', $id)->delete();

        Role::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
