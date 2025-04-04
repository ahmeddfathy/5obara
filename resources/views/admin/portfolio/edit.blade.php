@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Edit Portfolio Item</h1>

        <form action="{{ route('admin.portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="5" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $portfolio->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Project Image</label>
                @if($portfolio->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $portfolio->image) }}" alt="Current project image" class="h-32 w-auto">
                </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="client_name" class="block text-gray-700 text-sm font-bold mb-2">Client Name</label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="completion_date" class="block text-gray-700 text-sm font-bold mb-2">Completion Date</label>
                <input type="date" name="completion_date" id="completion_date" value="{{ old('completion_date', $portfolio->completion_date ? $portfolio->completion_date->format('Y-m-d') : '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="project_type" class="block text-gray-700 text-sm font-bold mb-2">Project Type</label>
                <input type="text" name="project_type" id="project_type" value="{{ old('project_type', $portfolio->project_type) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Technologies Used</label>
                <div class="flex flex-wrap gap-2">
                    @php
                        $commonTechnologies = ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Angular', 'Node.js', 'Python', 'Django', 'Ruby', 'Ruby on Rails', 'MySQL', 'PostgreSQL', 'MongoDB', 'CSS', 'HTML', 'Tailwind CSS', 'Bootstrap', 'AWS', 'Docker', 'Kubernetes'];
                        $portfolioTechnologies = old('technologies', $portfolio->technologies ?? []);
                        if (!is_array($portfolioTechnologies)) {
                            $portfolioTechnologies = [];
                        }
                    @endphp

                    @foreach($commonTechnologies as $tech)
                    <label class="inline-flex items-center mr-4 mb-2">
                        <input type="checkbox" name="technologies[]" value="{{ $tech }}"
                        {{ in_array($tech, $portfolioTechnologies) ? 'checked' : '' }}
                        class="form-checkbox h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">{{ $tech }}</span>
                    </label>
                    @endforeach

                    @if(is_array($portfolioTechnologies))
                        @foreach($portfolioTechnologies as $tech)
                            @if(!in_array($tech, $commonTechnologies))
                            <label class="inline-flex items-center mr-4 mb-2">
                                <input type="checkbox" name="technologies[]" value="{{ $tech }}" checked
                                class="form-checkbox h-4 w-4 text-blue-600">
                                <span class="ml-2 text-gray-700">{{ $tech }}</span>
                            </label>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="mt-2">
                    <label for="other_tech" class="block text-gray-700 text-sm mb-1">Other Technologies (comma-separated)</label>
                    <input type="text" id="other_tech" name="other_tech"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
            </div>

            <div class="mb-4">
                <label for="project_url" class="block text-gray-700 text-sm font-bold mb-2">Project URL</label>
                <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $portfolio->project_url) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}
                        class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-gray-700">Featured Project</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Portfolio Item
                </button>
                <a href="{{ route('admin.portfolio.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otherTechInput = document.getElementById('other_tech');

        otherTechInput.addEventListener('blur', function() {
            if (!this.value.trim()) return;

            const technologies = this.value.split(',').map(tech => tech.trim()).filter(tech => tech);

            technologies.forEach(tech => {
                if (!tech) return;

                const checkboxContainer = document.querySelector('.flex.flex-wrap.gap-2');

                // Check if tech already exists as a checkbox
                const existingCheckboxes = document.querySelectorAll('input[name="technologies[]"]');
                for (let checkbox of existingCheckboxes) {
                    if (checkbox.value === tech) {
                        checkbox.checked = true;
                        return;
                    }
                }

                // Create new checkbox for the tech
                const label = document.createElement('label');
                label.className = 'inline-flex items-center mr-4 mb-2';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'technologies[]';
                checkbox.value = tech;
                checkbox.checked = true;
                checkbox.className = 'form-checkbox h-4 w-4 text-blue-600';

                const span = document.createElement('span');
                span.className = 'ml-2 text-gray-700';
                span.textContent = tech;

                label.appendChild(checkbox);
                label.appendChild(span);
                checkboxContainer.appendChild(label);
            });

            // Clear the input field
            this.value = '';
        });
    });
</script>
@endpush
@endsection
