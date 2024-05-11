<?php

namespace Drupal\drupal_form\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Drupal form with an example of form validation.
 */
class DrupalForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'drupal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#placeholder' => 'Enter the title',
      '#required' => TRUE,
    ];

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#placeholder' => 'Enter the name',
      '#required' => TRUE,
    ];
    $form['age'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Age'),
      '#placeholder' => 'Enter the age',
      '#required' => TRUE,
    ];
    $form['qualification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Qualification'),
      '#placeholder' => 'Enter the qualification',
      '#required' => TRUE,
    ];
    $form['images'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Images'),
      '#upload_location' => 'public://images/',
      '#required' => TRUE,
      '#upload_validators' => [
        'file_validate_extensions' => ['png gif jpg jpeg'],
      ],
    ];


    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
    

  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (strlen($form_state->getValue('name')) < 3) {
      $form_state->setErrorByName(
        'name',
        $this->t('Your name should be longer than 3 letters in order for me to say it ;)')
      );
    }

    if (!is_numeric($form_state->getValue('age')) || $form_state->getValue('age') <= 0) {
      $form_state->setErrorByName(
        'age',
        $this->t('Please enter a valid age.')
      );
    }

    if (strlen($form_state->getValue('qualification')) < 2) {
      $form_state->setErrorByName(
        'qualification',
        $this->t('Please enter a valid qualification.')
      );
    }
    $file = $form_state->getValue('images');
    if (empty($file[0])) {
      $form_state->setErrorByName('images', $this->t('Please upload an image.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Retrieve submitted values
    $title = $form_state->getValue('title');
    $name = $form_state->getValue('name');
    $age = $form_state->getValue('age');
    $qualification = $form_state->getValue('qualification');
    $images = $form_state->getValue('images');

    // Save to content
    $this->saveContent($title, $name, $age, $qualification, $images);


    // Optionally, you can also show a message to the user
    $connection = Database::getConnection();
    $connection->insert('user_info')
      ->fields([
        'title' => $title,
        'name' => $name,
        'age' => $age,
        'qualification' => $qualification,
        'images' => $images[0], // Assuming managed_file returns an array with single value
      ])
      ->execute();

    $form_state->setRedirect('drupal_form.drupal_validation_form_controller');
    \Drupal::messenger()->addMessage($this->t('Form submitted successfully!'));

  }

  private function saveContent($title, $name, $age, $qualification, $images)
  {

    $nid = \Drupal::request()->query->get('id');
    if ($nid) {

      $node = \Drupal\node\Entity\Node::load($nid);
      if ($node) {
        // Update the field values.
        $node->set('title', $title);
        $node->set('field_name', $name);
        $node->set('field_age', $age);
        $node->set('field_qualification', $qualification);
        $node->set('field_images', $images);
        // Save the updated node.
        $node->save();

      }

    } else {
      $entity = \Drupal::entityTypeManager()->getStorage('node')->create([
        'type' => 'students',
        'title' => $title,
        'field_name' => $name,
        'field_age' => $age,
        'field_qualification' => $qualification,
        'field_images' => $images,
      ]);
      $entity->save();
      // dd($entity);

    }


  }
}
