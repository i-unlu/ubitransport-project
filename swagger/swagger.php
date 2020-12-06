<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="AUSG", version="0.1")
 * @OA\Server(
 *     url="http://api.ubitransport.student-grading.fr/v1",
 *     description="Api Ubitransport Student Grading",
 * )
 *
 * @OA\Schema(
 *     schema="StudentInformation",
 *     type="object",
 *     description="Student informations",
 *     @OA\Property(type="string", property="last_name", example="UNLU"),
 *     @OA\Property(type="string", property="first_name", example="izzetali"),
 *     @OA\Property(type="string", format="date", property="birth_date", example="1981-03-22")
 * )
 *
 * @OA\Schema(
 *     schema="AverageNote",
 *     type="object",
 *     description="Average note",
 *     @OA\Property(type="string", property="subject", example="Mathematique"),
 *     @OA\Property(type="float", property="note", example="12"),
 *     @OA\Property(type="integer", property="student_id", example="1")
 * )
 */
