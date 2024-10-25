<?php

class IlalinUtils {
    // Constants
    private const PAYMENT_PER_KM = 1000; // Rp 1000 per km
    private const DRIVER_PROFIT_PERCENTAGE = 0.8333; // 83.33%

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
        return match (strtoupper($country)) {
            'ID' => 'Rp ' . number_format($amount, 2, ',', '.'), // Indonesia (Rp)
            'US' => '$' . number_format($amount, 2, '.', ','),   // US Dollar ($)
            default => number_format($amount, 2), // Default formatting
        };
    }
}