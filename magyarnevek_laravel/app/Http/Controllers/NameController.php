<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NameController extends Controller
{
    private const FILTERS = ['firstLetter', 'sex', 'certificate', 'group', 'search', 'searchIn', 'pageToken'];

    public function index(Request $request)
    {
        $query = array_filter(
            $request->only(self::FILTERS),
            fn ($v) => $v !== null && $v !== ''
        );
        $query['fields'] = '*';
        $query['limit'] = 20;

        $response = Http::api()->get('/names', $query);

        if ($response->failed()) {
            session()->now('error', 'Hiba történt az adatok lekérdezése során.');

            return view('names.index', [
                'names' => [],
                'nextToken' => null,
                'filters' => $request->only(self::FILTERS),
            ]);
        }

        $json = $response->json();

        return view('names.index', [
            'names' => $json['data'] ?? [],
            'nextToken' => $this->extractToken($json['nextPageToken'] ?? null),
            'filters' => $request->only(self::FILTERS),
        ]);
    }

    private function extractToken(?string $url): ?string
    {
        if (!$url) {
            return null;
        }
        parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $params);

        return $params['pageToken'] ?? null;
    }

    public function show(Request $request)
    {

    }
}
