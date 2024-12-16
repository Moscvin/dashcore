<table>
	<tbody>
        <thead>
            <tr>
                <th colspan="35" style="text-align: center" > {{ $headerTitle }} </th>
            </tr>
            <tr>
                <th>Cod. Customere</th>
                <th>Tipo Customere</th>
                <th>Denominazione</th>
                <th>Nato il</th>
                <th>Nato A</th>
                <th>Nazionalità</th>
                <th>Partita IVA</th>
                <th>Codice Fiscale</th>
                <th>Telefono</th>
                <th>Telefono2</th>
                <th>Fax</th>
                <th>Email</th>
                <th>PEC</th>
                <th>Via</th>
                <th>Civico</th>
                <th>CAP</th>
                <th>Località</th>
                <th>Comune</th>
                <th>Provincia</th>
                <th>Nazione</th>
                <th>Via2</th>
                <th>Civico2</th>
                <th>CAP2</th>
                <th>Località2</th>
                <th>Comune2</th>
                <th>Provincia2</th>
                <th>Nazione2</th>
                <th>Rappresentante Legale</th>
                <th>Telefono Rappr. Leg.</th>
                <th>Email Rappr. Leg.</th>
                <th>Tipo Referente</th>
                <th>Nominativo Referente</th>
                <th>Telefono Referente</th>
                <th>Email Referente</th>
                <th>Visibile</th>
            </tr>
         </thead>
         @if (count($customers))
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer['id'] }}</td>
                    <td>{{ $customer['type'] }}</td>
                    <td>{{ $customer['is_company'] }}</td>
                    <td>{{ $customer['data_of_birth'] }}</td>
                    <td>{{ $customer['city_birth'] }}</td>
                    <td>{{ $customer['country_fiscal'] }}</td>
                    <td>{{ $customer['vat_number'] }}</td>
                    <td>{{ $customer['code_fiscal'] }}</td>
                    <td>{{ $customer['telefono'] }}</td>
                    <td>{{ $customer['telefono2'] }}</td>
                    <td>{{ $customer['fax'] }}</td>
                    <td>{{ $customer['email'] }}</td>
                    <td>{{ $customer['pec'] }}</td>
                    <td>{{ $customer['street_address_sl'] }}</td>
                    <td>{{ $customer['house_number_sl'] }}</td>
                    <td>{{ $customer['zip_sl'] }}</td>
                    <td>{{ $customer['location_sl'] }}</td>
                    <td>{{ $customer['city_sl'] }}</td>
                    <td>{{ $customer['province_sl'] }}</td>
                    <td>{{ $customer['country_sl'] }}</td>
                    <td>{{ $customer['street_address_so'] }}</td>
                    <td>{{ $customer['house_number_so'] }}</td>
                    <td>{{ $customer['zip_so'] }}</td>
                    <td>{{ $customer['location_so'] }}</td>
                    <td>{{ $customer['city_so'] }}</td>
                    <td>{{ $customer['province_so'] }}</td>
                    <td>{{ $customer['country_so'] }}</td>
                    <td>{{ $customer['name'] }}</td>
                    <td>{{ $customer['rl_telefono'] }}</td>
                    <td>{{ $customer['rl_email'] }}</td>
                    <td>{{ $customer['referent_description'] }}</td>
                    <td>{{ $customer['referent_name'] }}</td>
                    <td>{{ $customer['referente_telefono'] }}</td>
                    <td>{{ $customer['referent_email'] }}</td>
                    <td>{{ $customer['visible'] }}</td>

                </tr>
            @endforeach             
         @endif
	</tbody>
</table>