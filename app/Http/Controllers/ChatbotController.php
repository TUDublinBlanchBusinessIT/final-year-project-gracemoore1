<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function studentChat()
    {
        return view('student.chatbot');
    }

    public function landlordChat()
    {
        return view('landlord.chatbot');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'role' => 'required|string|in:student,landlord',
        ]);

        $message = strtolower(trim($request->message));

        $faqs = Faq::where('is_active', true)
            ->where(function ($query) use ($request) {
                $query->where('role', $request->role)
                    ->orWhere('role', 'all');
            })
            ->get();

        $bestFaq = null;
        $bestScore = 0;

        $commonWords = [
            'how', 'do', 'i', 'a', 'the', 'is', 'to', 'my', 'can',
            'what', 'where', 'when', 'and', 'for', 'of', 'on', 'in'
        ];

        foreach ($faqs as $faq) {
            $score = 0;

            $questionWords = preg_split('/\s+/', strtolower($faq->question));
            $keywordWords = $faq->keywords
                ? array_map('trim', explode(',', strtolower($faq->keywords)))
                : [];

            foreach ($questionWords as $word) {
                $word = trim($word);

                if ($word === '' || in_array($word, $commonWords)) {
                    continue;
                }

                if (str_contains($message, $word)) {
                    $score += 1;
                }
            }

            foreach ($keywordWords as $keyword) {
                if ($keyword === '') {
                    continue;
                }

                if (str_contains($message, $keyword)) {
                    $score += 2;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq = $faq;
            }
        }

        if ($bestFaq && $bestScore > 0) {
            return response()->json([
                'reply' => $bestFaq->answer,
                'matched_question' => $bestFaq->question,
            ]);
        }

        return response()->json([
            'reply' => 'Sorry, I could not find an answer for that yet. Please try asking another question.',
            'matched_question' => null,
        ]);
    }
}