<?php
include_once(__DIR__. '/ilalinUtils.php');
class PaymentsUtils extends IlalinUtils {
    /**
     * Calculates the total payment for a trip based on distance.
     */
    public function calculateTotalPayment(int $distance): float {
        if ($distance < 0) {
            throw new InvalidArgumentException("Distance must be non-negative.");
        }
        return self::PAYMENT_PER_KM * $distance;
    }

    /**
     * Calculates both driver and company profits from the total payment.
     */
    public function calculateProfits(float $totalPayment): array {
        $driverProfit = round($totalPayment * self::DRIVER_PROFIT_PERCENTAGE, 2);
        $companyProfit = round($totalPayment - $driverProfit, 2);

        return [
            'driverProfit' => $driverProfit,
            'companyProfit' => $companyProfit
        ];
    }

    /**
     * Formats a given amount according to the country's currency format.
     */
    public function formatCurrency(float $amount, string $country = 'ID'): string {
        switch (strtoupper($country)) {
            case 'ID':
                return 'Rp. ' . number_format($amount, 2, ',', '.'); // Indonesia (Rp)
            case 'US':
                return '$' . number_format($amount, 2, '.', ','); // US Dollar ($)
            default:
                return number_format($amount, 2); // Default formatting
        }
    }

}