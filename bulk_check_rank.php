<?php
// bulk_check_rank.php

if ($argc < 2) {
    echo "Usage: php bulk_check_rank.php wallets.txt\n";
    exit(1);
}

$walletsFile = $argv[1];
if (!file_exists($walletsFile)) {
    echo "File not found: $walletsFile\n";
    exit(1);
}

$wallets = file($walletsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (count($wallets) === 0) {
    echo "No wallet addresses found in $walletsFile\n";
    exit(1);
}

$outputFile = 'rank_results.csv';
$fp = fopen($outputFile, 'w');
fputcsv($fp, ['Wallet', 'Rank', 'Transactions', 'Contracts Interacted', 'Active Days', 'MON Balance']);

function fetchWalletData($wallet) {
    $url = "https://layerhub.xyz/api/search?p=monad_testnet&q=" . urlencode($wallet);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Optional: set user agent or headers if needed
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP CLI Bulk Rank Checker');

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo "Curl error for wallet $wallet: " . curl_error($ch) . "\n";
        curl_close($ch);
        return null;
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if (!$data) {
        echo "Failed to decode JSON for wallet $wallet\n";
        return null;
    }

    // The structure depends on LayerHub API response
    // Example expected keys: rank, transactions, contracts_interacted, active_days, mon_balance
    // Adjust parsing according to actual API response structure

    if (empty($data['results']) || count($data['results']) === 0) {
        echo "No data found for wallet $wallet\n";
        return null;
    }

    $walletData = $data['results'][0]; // Assume first result is the wallet info

    return [
        'rank' => $walletData['rank'] ?? 'N/A',
        'transactions' => $walletData['transactions'] ?? 'N/A',
        'contracts_interacted' => $walletData['contracts_interacted'] ?? 'N/A',
        'active_days' => $walletData['active_days'] ?? 'N/A',
        'mon_balance' => $walletData['mon_balance'] ?? 'N/A',
    ];
}

foreach ($wallets as $wallet) {
    echo "Checking wallet: $wallet ... ";
    $info = fetchWalletData($wallet);
    if ($info === null) {
        echo "No data\n";
        fputcsv($fp, [$wallet, 'No data', '', '', '', '']);
        continue;
    }
    echo "Rank: {$info['rank']}, Tx: {$info['transactions']}\n";
    fputcsv($fp, [
        $wallet,
        $info['rank'],
        $info['transactions'],
        $info['contracts_interacted'],
        $info['active_days'],
        $info['mon_balance'],
    ]);
}

fclose($fp);
echo "Results saved to $outputFile\n";
