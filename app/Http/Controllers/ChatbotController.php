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
        $message = preg_replace('/[^\w\s]/', '', $message);
        $message = preg_replace('/\s+/', ' ', $message);

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
            'what', 'where', 'when', 'and', 'for', 'of', 'on', 'in',
            'it', 'as', 'at', 'by', 'an', 'want', 'we', 'our', 'me'
        ];

        foreach ($faqs as $faq) {
            $score = 0;

            $faqQuestion = strtolower(trim($faq->question));
            $faqQuestion = preg_replace('/[^\w\s]/', '', $faqQuestion);
            $faqQuestion = preg_replace('/\s+/', ' ', $faqQuestion);

            $questionWords = preg_split('/\s+/', $faqQuestion);

            $keywordWords = $faq->keywords
                ? array_map('trim', explode(',', strtolower($faq->keywords)))
                : [];

            if ($message === $faqQuestion) {
                $score += 15;
            }

            foreach ($keywordWords as $keyword) {
                $keyword = preg_replace('/[^\w\s]/', '', trim($keyword));
                $keyword = preg_replace('/\s+/', ' ', $keyword);

                if ($keyword === '') {
                    continue;
                }

                if (str_contains($keyword, ' ')) {
                    if (str_contains($message, $keyword)) {
                        $score += 12;
                    }
                } else {
                    if (in_array($keyword, $commonWords)) {
                        continue;
                    }

                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $message)) {
                        $score += 5;
                    }
                }
            }

            foreach ($questionWords as $word) {
                $word = trim($word);

                if ($word === '' || in_array($word, $commonWords)) {
                    continue;
                }

                if (preg_match('/\b' . preg_quote($word, '/') . '\b/', $message)) {
                    $score += 1;
                }
            }

            $hasGroupInMessage = preg_match('/\bgroup\b/', $message);
            $hasApplyInMessage = preg_match('/\bapply\b/', $message);
            $hasPropertyInMessage = preg_match('/\bproperty\b|\bproperties\b/', $message);
            $hasListingInMessage = preg_match('/\blisting\b/', $message);

            $hasViewInMessage = preg_match('/\bview\b|\bsee\b|\bcheck\b/', $message);
            $hasApplicationsInMessage = preg_match('/\bapplication\b|\bapplications\b|\bapplicant\b|\bapplicants\b|\bapplied\b/', $message);

            $hasCreateInMessage = preg_match('/\bcreate\b|\bupload\b|\badd\b|\bpost\b|\bmake\b/', $message);

            $faqKeywordsText = ' ' . strtolower($faq->keywords ?? '') . ' ';
            $faqQuestionText = ' ' . strtolower($faq->question ?? '') . ' ';

            if (
                $hasGroupInMessage &&
                ($hasApplyInMessage || $hasApplicationsInMessage) &&
                ($hasPropertyInMessage || $hasListingInMessage)
            ) {
                if (
                    str_contains($faqKeywordsText, 'group') ||
                    str_contains($faqQuestionText, 'group')
                ) {
                    $score += 20;
                }
            }

            if (
                !$hasGroupInMessage &&
                $hasApplyInMessage &&
                ($hasPropertyInMessage || $hasListingInMessage)
            ) {
                if (
                    str_contains($faqKeywordsText, 'apply') ||
                    str_contains($faqQuestionText, 'apply')
                ) {
                    $score += 10;
                }
            }

            if ($hasCreateInMessage && ($hasListingInMessage || $hasPropertyInMessage)) {
                if (
                    str_contains($faqKeywordsText, 'listing') ||
                    str_contains($faqQuestionText, 'listing')
                ) {
                    $score += 20;
                }
            }

            if ($hasViewInMessage && $hasApplicationsInMessage) {
                if (
                    str_contains($faqKeywordsText, 'application') ||
                    str_contains($faqKeywordsText, 'applicant') ||
                    str_contains($faqQuestionText, 'application')
                ) {
                    $score += 20;
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq = $faq;
            }
        }

        if ($bestFaq && $bestScore >= 5) {
            return response()->json([
                'reply' => $bestFaq->answer,
                'matched_question' => $bestFaq->question,
            ]);
        }

        return response()->json([
            'reply' => 'Sorry, I could not find an answer for that yet. Please try asking another question, or email your question to rentconnect.app@gmail.com.',
            'matched_question' => null,
        ]);
    }
}