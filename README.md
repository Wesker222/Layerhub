# Layerhub

## Monad Testnet Rank Checker

Layerhub is a simple tool designed to check and retrieve ranking and activity data for wallets on the Monad Testnet blockchain. It helps users and developers bulk query wallet ranks, transaction counts, and other engagement metrics using the Layerhub API.

Updated: 05/09 getting ready for Monad EVM deployment

## Features

- Bulk wallet rank checking on Monad Testnet
- Retrieves wallet statistics such as rank, transaction count, active days, and token balances
- Easy-to-use CLI or script integration
- Useful for analytics, leaderboard tracking, and testnet monitoring

## Installation

Clone the repository:

```bash
git clone https://github.com/Wesker222/Layerhub.git
cd Layerhub
```

Install dependencies (if any, depending on language used):

```bash
# Example for PHP or Python, adjust accordingly
```

## Usage

Prepare a list of Monad Testnet wallet addresses in a text file (one per line).

Run the rank checker script with your list to retrieve wallet rankings and activity data.

Example (PHP CLI):

```bash
php bulk_check_rank.php wallets.txt
```

The script will output results to a CSV file for easy analysis.

## API Reference

The tool uses the Layerhub API endpoint for Monad Testnet:

```
https://layerhub.xyz/api/search?p=monad_testnet&q=
```

Adjust the API usage as needed based on Layerhub documentation.

## Contributing

Contributions, bug reports, and feature requests are welcome! Please open issues or submit pull requests.

## License

This project is licensed under the MIT License.

