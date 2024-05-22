<div style="background-color:#f2f2f2">
	<table width="550px" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
		<tbody>
			<tr style="background-color: #f2f2f2;">
				<td width="100%" height="40" style="border-collapse:collapse"></td>
			</tr>
			<tr style="width:100%;text-align:center;">
				<td style="padding-top: 30px;padding-bottom: 15px;font-size:25px;font-weight:700;text-align:center;">{{ config('app.name', 'Laravel') }}</td>
			</tr>
			<tr style="float:left;padding:0px 30px">
				<td style="padding:15px 0px;font-size:17px;font-weight:700;text-transform:capitalize">Dear {{ $user->name }},</td>
			</tr>
			<tr style="float:left;padding:0px 30px;clear:both">
				<td>Welcome to {{ config('app.name', 'Laravel') }}.</td>
			</tr>
			<tr style="float:left;padding:15px 30px;clear:both">
				<td>You Have successfully Registered With us...!!.</td>
			</tr>
			<tr style="float:left;padding:0px 30px;clear:both">
				<td style="font-weight:bold">Username:</td>
				<td>{{ $user->email }}</td>
			</tr>
			{{--
			<tr style="float:left;padding:0px 30px;clear:both">
				<td style="font-weight:bold">Password:</td>
				<td>{{ $user->password }}</td>
			</tr>
			--}}
			<tr>
				<td width="100%" height="20" style="border-collapse:collapse"></td>
			</tr>
			<tr style="float:left;padding:5px 30px;font-weight:bold;width:100%">
				<td>Please click on following link to activate your account:</td>
			</tr>
			<tr style="float:left;padding:0px 30px">
				<td><a href="{{ route('user.loginForm',['activation'=>$user->activation,'email'=>$user->email]) }}">Activate</a></td>
			</tr>		
			<tr>
				<td width="100%" height="25" style="border-collapse:collapse"></td>
			</tr>
			<tr style="float:left;padding:15px 30px 0px;clear:both;font-weight:bold">
				<td>Thanks,</td>
			</tr>
			<tr style="float:left;padding:0px 30px;clear:both">
				<td>{{ config('app.name', 'Laravel') }} Support</td>
			</tr>
			
			<tr>
				<td width="100%" height="40" style="border-collapse:collapse"></td>
			</tr>
			<tr style="padding:0px 30px;width:100%;background-color:#f2f2f2">
				<td style="padding:30px 0px;font-size:11px;text-align:center">
					© {{ date('Y')}} {{ config('app.name', 'Laravel') }}.
				</td>
			</tr>
		</tbody>
	</table>
</div>