<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Fixed set of static pages, editable from the admin panel afterwards.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about',
                'title_ka' => 'ჟურნალის შესახებ',
                'title_en' => 'About the Journal',
                'body_ka' => '<p>„მართლმსაჯულება და კანონი" (ISSN 1512-259X) არის სამართლებრივი ჟურნალი, რომელიც აქვეყნებს სამეცნიერო სტატიებს სამართლის სხვადასხვა დარგში. ტექსტი რედაქტირებადია ადმინ პანელიდან.</p>',
                'body_en' => '<p>"Justice and Law" (ISSN 1512-259X) is a legal journal publishing academic articles across various fields of law. This text is editable from the admin panel.</p>',
            ],
            [
                'slug' => 'aims-scope',
                'title_ka' => 'მიზნები და ამოცანები',
                'title_en' => 'Aims & Scope',
                'body_ka' => '<p>ჟურნალის მიზნები და ამოცანები. ტექსტი რედაქტირებადია ადმინ პანელიდან.</p>',
                'body_en' => '<p>The aims and scope of the journal. This text is editable from the admin panel.</p>',
            ],
            [
                'slug' => 'review-ethics',
                'title_ka' => 'რეცენზირება და ეთიკა',
                'title_en' => 'Review & Ethics',
                'body_ka' => '<p>რეცენზირებისა და საგამომცემლო ეთიკის წესები. ტექსტი რედაქტირებადია ადმინ პანელიდან.</p>',
                'body_en' => '<p>Peer review and publication ethics policy. This text is editable from the admin panel.</p>',
            ],
            [
                'slug' => 'editorial-board',
                'title_ka' => 'სარედაქციო კოლეგია',
                'title_en' => 'Editorial Board',
                'body_ka' => '<p>სარედაქციო კოლეგიის შემადგენლობა. ტექსტი რედაქტირებადია ადმინ პანელიდან.</p>',
                'body_en' => '<p>Members of the editorial board. This text is editable from the admin panel.</p>',
            ],
            [
                'slug' => 'for-authors',
                'title_ka' => 'ავტორთა საყურადღებოდ',
                'title_en' => 'For Authors',
                'body_ka' => <<<'HTML'
                    <p>ჟურნალი „მართლმსაჯულება და კანონი" იღებს გამოსაქვეყნებლად ორიგინალურ, ადრე გამოუქვეყნებელ სამეცნიერო სტატიებს სამართლის სხვადასხვა დარგში. სტატიის წარმოდგენამდე გთხოვთ, გაეცნოთ ქვემოთ მოცემულ მოთხოვნებს.</p>

                    <h3>ტექნიკური მოთხოვნები</h3>
                    <ul>
                        <li>ენა — ქართული ან ინგლისური.</li>
                        <li>ფორმატი — Microsoft Word (.doc/.docx).</li>
                        <li>მოცულობა — 15-დან 40 გვერდამდე, სქოლიოების ჩათვლით.</li>
                        <li>ფონტი — Sylfaen, ზომა 12; სტრიქონთაშორისი დაშორება — 1.5.</li>
                        <li>გვერდის ველები — 2.5 სმ ყველა მხრიდან.</li>
                    </ul>

                    <h3>სტატიის სტრუქტურა</h3>
                    <ol>
                        <li>სათაური — ქართულ და ინგლისურ ენებზე.</li>
                        <li>ავტორის სახელი, გვარი, აკადემიური/სამსახურებრივი სტატუსი და საკონტაქტო ინფორმაცია.</li>
                        <li>რეზიუმე (200–250 სიტყვა) ორივე ენაზე.</li>
                        <li>საკვანძო სიტყვები (5–7) ორივე ენაზე.</li>
                        <li>ძირითადი ტექსტი — შესავალი, ძირითადი ნაწილი, დასკვნა.</li>
                        <li>გამოყენებული ლიტერატურის ნუსხა.</li>
                    </ol>

                    <h3>დამოწმებები</h3>
                    <p>დამოწმებები მოცემული უნდა იყოს სქოლიოს სახით გვერდის ბოლოში, ერთგვაროვანი სტანდარტის დაცვით (ავტორი, ნაშრომის სათაური, გამოცემის ადგილი და წელი, გვერდი).</p>

                    <h3>რეცენზირება</h3>
                    <p>წარმოდგენილი სტატიები გადის რეცენზირებას — დეტალები იხილეთ გვერდზე „რეცენზირება და ეთიკა".</p>

                    <h3>სტატიის წარმოდგენა</h3>
                    <p>სტატიის გამოსაგზავნად გამოიყენეთ „კონტაქტი" გვერდზე მითითებული ელ-ფოსტის მისამართი. ავტორმა უნდა დაადასტუროს, რომ ნაშრომი ორიგინალურია და არ იმყოფება სხვა გამოცემაში განხილვის პროცესში.</p>
                    HTML,
                'body_en' => <<<'HTML'
                    <p>"Justice and Law" accepts original, previously unpublished academic articles across various fields of law. Please review the requirements below before submitting your manuscript.</p>

                    <h3>Technical requirements</h3>
                    <ul>
                        <li>Language — Georgian or English.</li>
                        <li>Format — Microsoft Word (.doc/.docx).</li>
                        <li>Length — 15 to 40 pages, including footnotes.</li>
                        <li>Font — Sylfaen, size 12; line spacing — 1.5.</li>
                        <li>Margins — 2.5 cm on all sides.</li>
                    </ul>

                    <h3>Manuscript structure</h3>
                    <ol>
                        <li>Title — in both Georgian and English.</li>
                        <li>Author's full name, academic/professional affiliation, and contact information.</li>
                        <li>Abstract (200–250 words) in both languages.</li>
                        <li>Keywords (5–7) in both languages.</li>
                        <li>Main text — introduction, body, conclusion.</li>
                        <li>List of references.</li>
                    </ol>

                    <h3>Citations</h3>
                    <p>Citations should be provided as footnotes at the bottom of the page, following a consistent format (author, title of work, place and year of publication, page).</p>

                    <h3>Peer review</h3>
                    <p>Submitted articles undergo peer review — see the "Review &amp; Ethics" page for details.</p>

                    <h3>Submission</h3>
                    <p>To submit an article, use the email address listed on the "Contact" page. Authors must confirm that the manuscript is original and not under review elsewhere.</p>
                    HTML,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
