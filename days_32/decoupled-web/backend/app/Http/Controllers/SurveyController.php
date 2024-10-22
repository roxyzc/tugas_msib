<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function find(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $surveys = Survey::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'total' => $surveys->total(),
            'current_page' => $surveys->currentPage(),
            'per_page' => $surveys->perPage(),
            'data' => $surveys->items(),
        ]);
    }

    public function findById($id)
    {
        $survey = Survey::find($id);
        if (!$survey) {
            return response()->json(['success' => false, 'msg' => 'Survey not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $survey]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'survey_data' => 'required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'msg' => $errors,
            ], 422);
        }

        $surveyData = [
            'user_id' => $request->auth->id,
            'title' => $request->input('title'),
            'survey_data' => json_encode($request->input('survey_data')),
        ];

        $survey = Survey::create($surveyData);
        return response()->json($survey, 201);
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::find($id);
        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'survey_data' => 'sometimes|required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'success' => false,
                'msg' => $errors,
            ], 422);
        }

        $survey->update([
            'title' => $request->input('title', $survey->title),
            'survey_data' => isset($request->survey_data) ? json_encode($request->input('survey_data')) : $survey->survey_data,
        ]);

        return response()->json($survey);
    }

    public function destroy($id)
    {
        $survey = Survey::find($id);
        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        $survey->delete();
        return response()->json(['message' => 'Survey deleted successfully']);
    }
}
