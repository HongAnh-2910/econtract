<div style="background: linear-gradient(180deg, #3919B9 0%, #4A21C0 51.04%, #5F27D8 100%); border-radius: 29px; display: flex; padding-bottom: 195px; flex-direction: column; align-items: center; width: 100%">
    <table style="width: 100%;">
        <tr>
            <div style="padding-left: 25px; padding-top: 22px">
                <img src="http://hddt.dtatech.vn/images/Logo_OneSign.png" style="width: 179px; height: 81px;"/>
            </div>
        </tr>
        <tr style="display: flex; width: 100%; justify-content: center">
            <td style=" display: flex; text-align: center;vertical-align: middle; margin: 0 auto; margin-bottom: 15px;">
                <img src="http://hddt.dtatech.vn/images/email_template.png" alt="email_body" style="width: 185px; height: 185px; border-radius: 185px"/>
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%; margin-top: 15px;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    color: #FFFFFF;">
                Hi Admin Onesign,
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%; margin-top: 15px;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    margin-bottom: 15px;
                    color: #FFFFFF;">
                Khách hàng {{ $data->business_name }} đã yêu cầu đăng ký gói cước
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%; margin-top: 15px;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    color: #FFFFFF;">
                Thông tin gói cước:
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%; margin-top: 15px;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    color: #FFFFFF;">
                - Tên gói cước: {{$data->type->name}}
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    color: #FFFFFF;">
                {!! $data->type->description !!}
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%;">
            <td
                style="
                    font-size: 20px;
                    align-items: center;
                    text-align: center;
                    letter-spacing: 0.04em;
                    vertical-align: middle;
                    margin: 0 auto;
                    max-width: 75%;
                    line-height: 1;
                    color: #FFFFFF;">
                - Thời hạn gói: 0{{$data->duration_package}} năm
            </td>
        </tr>
        <tr style="display: flex; justify-content: center; width: 100%; margin-top: 40px;">
            <td style="border: 1px solid #C4C4C4; box-sizing: border-box; border-radius: 6px; padding: 8px 15px; margin: 0 auto;">
                <a style="font-style: normal; text-decoration: none;font-weight: bold; font-size: 22px; line-height: 1; display: flex; align-items: center; text-align: center; letter-spacing: 0.04em;color: #FFFFFF;" href="#">
                    XEM GÓI CƯỚC ĐĂNG KÝ
                </a>
            </td>
        </tr>
    </table>
</div>
