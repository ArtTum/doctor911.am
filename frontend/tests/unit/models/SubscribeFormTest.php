<?php

namespace frontend\tests\unit\models;

use frontend\models\SubscribeForm;

class SubscribeFormTest extends \Codeception\Test\Unit
{
    public function testPublicInputNormalizesAValidPhone()
    {
        $model = new SubscribeForm([
            'full_name' => '  Արամ Սարգսյան  ',
            'phone' => '(+374) 77-123-456',
        ]);

        $this->assertTrue($model->validate(['full_name', 'phone']));
        $this->assertSame('Արամ Սարգսյան', $model->full_name);
        $this->assertSame('+37477123456', $model->phone);
    }

    public function testPublicInputRejectsJunkNameAndPhone()
    {
        $model = new SubscribeForm([
            'full_name' => '123456',
            'phone' => '00000000',
        ]);

        $this->assertFalse($model->validate(['full_name', 'phone']));
        $this->assertArrayHasKey('full_name', $model->getErrors());
        $this->assertArrayHasKey('phone', $model->getErrors());
    }

    public function testArrayPayloadIsRejectedWithoutThrowing()
    {
        $model = new SubscribeForm([
            'full_name' => ['not', 'a', 'name'],
            'phone' => ['not', 'a', 'phone'],
        ]);

        $this->assertFalse($model->validate(['full_name', 'phone']));
        $this->assertArrayHasKey('full_name', $model->getErrors());
        $this->assertArrayHasKey('phone', $model->getErrors());
    }

    public function testPublicMassAssignmentCannotSetDatabaseControlledFields()
    {
        $model = new SubscribeForm();
        $model->load([
            'Subscribe' => [
                'full_name' => 'John Smith',
                'phone' => '+37477123456',
                'doctor' => 'Injected doctor',
                'hospital' => 'Injected hospital',
                'status' => 9,
                'date' => '2000-01-01',
                'doctor_id' => 12,
            ],
        ]);

        $this->assertFalse(property_exists($model, 'doctor'));
        $this->assertFalse(property_exists($model, 'hospital'));
        $this->assertFalse(property_exists($model, 'status'));
        $this->assertFalse(property_exists($model, 'date'));
        $this->assertSame(12, $model->doctor_id);
    }

    public function testSignedFormTokenAcceptsOnlyExpectedAge()
    {
        $model = new SubscribeForm([
            'form_token' => SubscribeForm::createFormToken(time() - 3),
        ]);

        $this->assertTrue($model->validate(['form_token']));

        $model->form_token = SubscribeForm::createFormToken(time() - 7201);
        $this->assertFalse($model->validate(['form_token']));
    }
}
