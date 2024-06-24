<?php
if ($argc !== 3) {
    echo "Usage: php phpcs-to-sarif.php input.xml output.sarif\n";
    exit(1);
}

$inputFile = $argv[1];
$outputFile = $argv[2];

if (!file_exists($inputFile)) {
    echo "Input file does not exist: $inputFile\n";
    exit(1);
}

$xmlContent = file_get_contents($inputFile);
$xml = simplexml_load_string($xmlContent);

$sarif = [
    '$schema' => 'https://schemastore.azurewebsites.net/schemas/json/sarif-2.1.0.json',
    'version' => '2.1.0',
    'runs' => [
        [
            'tool' => [
                'driver' => [
                    'name' => 'PHP_CodeSniffer',
                    'informationUri' => 'https://github.com/squizlabs/PHP_CodeSniffer',
                    'rules' => [],
                ],
            ],
            'results' => [],
        ],
    ],
];

foreach ($xml->file as $file) {
    $filePath = (string) $file['name'];

    foreach ($file->error as $error) {
        $sarif['runs'][0]['results'][] = [
            'ruleId' => (string) $error['source'],
            'message' => [
                'text' => (string) $error,
            ],
            'locations' => [
                [
                    'physicalLocation' => [
                        'artifactLocation' => [
                            'uri' => $filePath,
                        ],
                        'region' => [
                            'startLine' => (int) $error['line'],
                            'startColumn' => (int) $error['column'],
                        ],
                    ],
                ],
            ],
        ];

        $sarif['runs'][0]['tool']['driver']['rules'][] = [
            'id' => (string) $error['source'],
            'shortDescription' => [
                'text' => (string) $error,
            ],
            'fullDescription' => [
                'text' => (string) $error,
            ],
        ];
    }
}

file_put_contents($outputFile, json_encode($sarif, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "SARIF report saved to: $outputFile\n";
