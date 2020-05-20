@extends('layouts.pdf')

@section('web_title', 'Czarles | Equipment History Record')

@section('styles')

	<style type="text/css">
		table{
			width: 100%;
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>

@endsection

@section('content')

	<table>
		<thead>
			<tr>
				<th colspan="8" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="8" style="text-align: center;">
					Equipment History Record
				</th>
			</tr>
			<tr>
				<th colspan="8" style="height: 15px;"></th>
			</tr>
			<tr>
				<th colspan="4" style="border-bottom: 1px solid black;text-align: left;font-size: 14px;">
					Equipment Name: {{ $equipment->equipment_name }}
				</th>
				<th colspan="4"></th>
			</tr>
			<tr>
				<th colspan="4" style="border-bottom: 1px solid black;text-align: left;font-size: 14px;">
					Model No.: {{ $equipment->equipment_model_no }}
				</th>
				<th colspan="4"></th>
			</tr>
			<tr>
				<th colspan="8" style="height: 15px;"></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="8" style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					EQUIPMENT BASIC INFORMATION
				</td>
			</tr>
			<tr>
				<td colspan="3" style="border: 1px solid black;font-size: 12px;font-weight: bold;">
					Serial No.: {{ $equipment->equipment_serial_no }}
				</td>
				<td colspan="2" style="border: 1px solid black;font-size: 12px;font-weight: bold;">
					Chassis No.: {{ $equipment->equipment_chassis_no }}
				</td>
				<td colspan="3" style="border: 1px solid black;font-size: 12px;font-weight: bold;">
					Plate No.: {{ $equipment->equipment_plate_no }}
				</td>
			</tr>
			<tr>
				<td colspan="2" style="border: 1px solid black;font-size: 12px;font-weight: bold;vertical-align: top;height: 30px;">
					Date Purchased: {{ $equipment->equipment_date_purchased }}
				</td>
				<td colspan="3" style="border: 1px solid black;font-size: 12px;font-weight: bold;vertical-align: top;">
					Manufacturer: {{ $equipment->equipment_manufacturer }}
				</td>
				<td colspan="3" style="border: 1px solid black;font-size: 12px;font-weight: bold;vertical-align: top;">
					Engine No.: {{ $equipment->equipment_engine_no }}
				</td>
			</tr>
			<tr>
				<td colspan="8" style="height: 15px;"></td>
			</tr>
			<tr>
				<td colspan="8" style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					EQUIPMENT MAINTENANCE / REPAIR HISTORY RECORD
				</td>
			</tr>
			<tr>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Type (R/PM)
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Date
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Repair Job Order No.
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Trouble / Problem / Checkup
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Action Taken / Repair Results
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Date Completed / Repaired
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Test Conducted By
				</td>
				<td style="border: 1px solid black;text-align: center;font-size: 12px;font-weight: bold;">
					Accepted By
				</td>
			</tr>
			<?php 
				$size = count($repair_job_orders);
				for ($x = 0; $x < 25; $x++) {
					if($x < $size){
						// echo '<tr>
						// 	<td style="height: 18px; border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_date .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_source .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_in .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_out .'</td>
						// 	<td style="border: 1px solid black;"> </td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_purpose .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_withdrawn_by .'</td>
						// 	<td style="border: 1px solid black;">'. $repair_job_orders[$x]->inventory_stock_unit_location .'</td>
						// </tr>';
					}else{
						echo '<tr>
							<td style="height: 18px; border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
							<td style="border: 1px solid black;"></td>
						</tr>';
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8" style="height: 10px;"></td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Form No.:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">FM-PRO-CCS-RII-04</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Issue Status:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">02</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Revision No.:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">00</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Date Effective:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">30 June 2017</td>
			</tr>
			<tr>
				<td style="font-size: 10px;">Approved By:</td>
				<td colspan="7" style="font-weight: bold;font-size: 10px;">Proprietor/Gen. Manager</td>
			</tr>
			<tr>
				<td colspan="8" style="height: 10px;"></td>
			</tr>
		</tfoot>
	</table>

@endsection