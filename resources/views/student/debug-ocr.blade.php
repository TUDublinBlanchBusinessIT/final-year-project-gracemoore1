<h2>OCR Debug Output</h2>

@if(isset($response))
    <h3>Full API Response:</h3>
    <pre>{{ json_encode($response, JSON_PRETTY_PRINT) }}</pre>
@else
    <h3>OCR Parsed Text:</h3>
    <pre>{{ $text }}</pre>

    <h3>Student Details:</h3>
    <pre>
Firstname: {{ $student->firstname }}
Surname: {{ $student->surname }}
Date of Birth: {{ date('d/m/Y', strtotime($student->dateofbirth)) }}
    </pre>
@endif
