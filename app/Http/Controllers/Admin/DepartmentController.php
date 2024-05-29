<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Models\SuperSpeciality;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function Speciality()
    {
        $specialities = Speciality::where('status','<>',2)->OrderBy('id','desc')->get();

        return view('department.speciality.all_specialities', compact('specialities'));
    }

    public function AddSpeciality()
    {
        return view('department.speciality.add_specialities');
    }

    public function StoreSpeciality(Request $request)
    {

        Speciality::insert([

            'speciality'   => $request->speciality,
            'status'   => 1,
        ]);

        return redirect()->route('department.speciality')->with('error', 'Speciality added');
    }

    public function EditSpeciality(Request $request)
    {
        $id         = $request->id;
        $speciality = Speciality::findOrFail($id);

        return view('department.speciality.edit_specialities', compact('speciality'));
    }

    public function UpdateSpeciality(Request $request, $id)
    {

        Speciality::findOrFail($id)->update([

            'speciality' => $request->speciality,
            // 'status'   => 1,
        ]);

        return redirect()->route('department.speciality')->with('error', 'Speciality Updated');
    }


    public function DeleteSpeciality($id)
    {
        Speciality::findOrFail($id)->update([

            'status'     => 2,
        ]);

        return redirect()->back();
    }


    public function SuperSpeciality()
    {
        $super_specialities = SuperSpeciality::where('status','<>',2)->OrderBy('id','desc')->get();

        return view('department.super_speciality.all_super_specialities', compact('super_specialities'));
    }

    public function AddSuperSpeciality()
    {
        return view('department.super_speciality.add_super_specialities');
    }

    public function StoreSuperSpeciality(Request $request)
    {

        SuperSpeciality::insert([

            'super_speciality'   => $request->super_speciality,
            'status'   => 1,
        ]);

        return redirect()->route('department.super_speciality')->with('error', 'Super Speciality added');
    }

    public function EditSuperSpeciality(Request $request)
    {
        $id                 = $request->id;
        $super_speciality  = SuperSpeciality::findOrFail($id);

        return view('department.super_speciality.edit_super_specialities', compact('super_speciality'));
    }

    public function UpdateSuperSpeciality(Request $request, $id)
    {
        SuperSpeciality::findOrFail($id)->update([

            'super_speciality' => $request->super_speciality,
        ]);

        return redirect()->route('department.super_speciality')->with('error', 'Super Speciality Updated');
    }


    public function DeleteSuperSpeciality($id)
    {
        SuperSpeciality::findOrFail($id)->update([

            'status'     => 2,
        ]);

        return redirect()->back();
    }

    public function Department()
    {
        $departments = Department::where('status','<>',2)->OrderBy('id','desc')->get();

        return view('department.department_list', compact('departments'));
    }

    public function AddDepartment()
    {
        return view('department.add_department');
    }

    public function StoreDepartment(Request $request)
    {

        Department::insert([

            'department'   => $request->department,
            'status'   => 1,
        ]);

        return redirect()->route('department.list')->with('error', 'Department added');
    }

    public function EditDepartment(Request $request)
    {
        $id         = $request->id;
        $department = Department::findOrFail($id);

        return view('department.edit_department', compact('department'));
    }

    public function UpdateDepartment(Request $request, $id)
    {

        Department::findOrFail($id)->update([

            'department' => $request->department,
        ]);

        return redirect()->route('department.list')->with('error', 'Department Updated');
    }


    public function DeleteDepartment($id)
    {
        if($id != 1){

            Department::findOrFail($id)->update([

                'status'     => 2,
            ]);
        }

        return redirect()->back();
    }


}
