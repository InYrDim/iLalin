<?php

include_once(__DIR__.'/ilalin_app.php');

/**
 * Class Passenger
 *
 * Handles operations related to passengers.
 *
 * @package IlalinApp
 * @since   1.0.0
 */
class Passenger extends IlalinApp {

    /**
     * Get all passengers.
     *
     * Retrieves all users with the role of 'penumpang' (passenger).
     *
     * @return array|string Array of passengers if found, string message otherwise.
     */
    public function getAllPassengers() {
        try {
            // Query to select all users with the role of 'penumpang'
            $stmt = $this->db->query(
                'SELECT * FROM users'
            );
            $passengers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // Return passengers if found, otherwise return a message
            if ($passengers) {
                return $passengers;
            } else {
                return "No passengers found";
            }
        } catch (Exception $e) {
            // Handle exception and return error message
            echo "Failed to get passengers: " . $e->getMessage();
        }
    }

    /**
     * Delete a passenger by their email.
     *
     * Deletes the passenger's record and any related trips based on the provided email.
     *
     * @param string $userEmail Email address of the passenger to delete.
     */
    public function deletePassengerByEmail($userEmail) {
        try {
            $this->db->beginTransaction(); // Start a transaction

            // Find related trips for the given email
            $trips = $this->db->query(
                'SELECT * FROM trips WHERE email = ? ',
                ['s', $userEmail]
            )->get_result()->fetch_all(MYSQLI_ASSOC);

            // If trips are found, delete them
            if (is_array($trips)) {
                $this->db->query('DELETE FROM trips WHERE email = ?', ['s', $userEmail]);
            }

            // Remove the user record with the given email
            $this->db->query('DELETE FROM users WHERE email = ?', ['s', $userEmail]);

            $this->db->commit(); // Commit the transaction
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback the transaction if something fails
            echo "Failed to delete user: " . $e->getMessage();
        }
    }

}