<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\ExactTargetList;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;

class EmailSubscriptionsTest extends BaseTestCase
{
    private const ENCRYPTION_KEY = '0123456789abcdef0123456789abcdef0123456789abcdef';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'exact-target.encryption_key' => self::ENCRYPTION_KEY,
            'exact-target.client.baseUrl' => 'https://et.test/',
            'exact-target.client.baseAuthUrl' => 'https://et-auth.test/',
        ]);
    }

    public function test_new_visitor_can_choose_subscriptions(): void
    {
        $checkboxes = $this->getCheckboxes('/email-subscriptions');

        $this->assertEquals(['checked' => true, 'disabled' => true], $checkboxes['OptMuseum']);
        foreach ($this->otherLists() as $list) {
            $this->assertEquals(['checked' => false, 'disabled' => false], $checkboxes[$list], $list);
        }
    }

    public function test_subscriber_sees_their_current_subscriptions(): void
    {
        $this->fakeExactTarget([
            'optmuseum' => 'True',
            'optevents' => 'True',
            'optfamilyprograms' => 'False',
        ]);

        $checkboxes = $this->getCheckboxes('/email-subscriptions?e=' . $this->encryptEmail('test@example.com'));

        $this->assertEquals(['checked' => true, 'disabled' => true], $checkboxes['OptMuseum']);
        $this->assertEquals(['checked' => true, 'disabled' => false], $checkboxes['OptEvents']);
        $this->assertEquals(['checked' => false, 'disabled' => false], $checkboxes['OptFamilyPrograms']);
    }

    public function test_unsubscribed_user_sees_all_subscriptions_disabled(): void
    {
        $this->fakeExactTarget([
            'optmuseum' => 'False',
            'optevents' => 'True',
        ]);

        $checkboxes = $this->getCheckboxes('/email-subscriptions?e=' . $this->encryptEmail('test@example.com'));

        foreach (ExactTargetList::getList()->keys() as $list) {
            $this->assertEquals(['checked' => false, 'disabled' => true], $checkboxes[$list], $list);
        }
    }

    public function test_unsubscribe_link_disables_all_subscriptions(): void
    {
        $this->fakeExactTarget([
            'optmuseum' => 'True',
            'optevents' => 'True',
        ]);

        $checkboxes = $this->getCheckboxes('/email-subscriptions?unsubscribe=1&e=' . $this->encryptEmail('test@example.com'));

        foreach (ExactTargetList::getList()->keys() as $list) {
            $this->assertEquals(['checked' => false, 'disabled' => true], $checkboxes[$list], $list);
        }
    }

    private function otherLists(): array
    {
        return ExactTargetList::getList()->keys()->reject(fn ($list) => $list === 'OptMuseum')->all();
    }

    private function fakeExactTarget(array $values): void
    {
        Http::fake([
            'et-auth.test/*' => Http::response(['access_token' => 'token']),
            'et.test/*' => Http::response([
                'items' => [
                    [
                        'keys' => ['email' => 'test@example.com'],
                        'values' => $values,
                    ],
                ],
            ]),
        ]);
    }

    /**
     * Mirror of EmailSubscriptionsController::getDecryptedEmail
     */
    private function encryptEmail(string $email): string
    {
        $blockSize = 8;
        $padded = str_pad($email, (int) ceil(strlen($email) / $blockSize) * $blockSize, ' ');

        return urlencode(base64_encode(openssl_encrypt(
            $padded,
            'des-ede3-ecb',
            hex2bin(self::ENCRYPTION_KEY),
            OPENSSL_ZERO_PADDING,
            ''
        )));
    }

    /**
     * Returns the checked and disabled state of each subscription checkbox, keyed by list
     */
    private function getCheckboxes(string $uri): array
    {
        $response = $this->get($uri);
        $response->assertOk();

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($response->getContent());
        libxml_clear_errors();

        $checkboxes = [];
        foreach ((new DOMXPath($dom))->query('//input[@name="subscriptions[]"]') as $input) {
            $checkboxes[$input->getAttribute('value')] = [
                'checked' => $input->hasAttribute('checked'),
                'disabled' => $input->hasAttribute('disabled'),
            ];
        }

        return $checkboxes;
    }
}
